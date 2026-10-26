<?php

namespace Tests\Feature;

use App\Athlete;
use App\Mail\SwimTeam\STSignUp;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Tests\TestCase;

class AthleteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_hash_is_set_when_an_athlete_is_created()
    {
        $athlete = Athlete::factory()->create();

        $this->assertNotEmpty($athlete->hash);
    }

    #[Test]
    public function a_user_can_update_an_athlete_by_hash()
    {
        $athlete = Athlete::factory()->create();

        $this->post("/api/athlete/{$athlete->hash}", [
            'firstName' => 'John',
            'lastName' => 'Doe',
            // 'birthDate' => '2019-01-01',
            'email' => 'test@gmail.com',
            'phone' => '555-555-5555',
            'parent' => 'John Doe',
            'street' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zip' => '12345',
            'emergencyName' => 'Jane Doe',
            'emergencyRelationship' => 'Mother',
            'emergencyPhone' => '555-555-5555',
        ])->assertStatus(200);

        $freshAthlete = Athlete::findByHash($athlete->hash)->first();

        $this->assertEquals('John', $freshAthlete->firstName);
        $this->assertEquals('Doe', $freshAthlete->lastName);
        // todo format carbon date to string for assertion
        // $this->assertEquals('2019-01-01', $freshAthlete->birthDate);
        $this->assertEquals('test@gmail.com', $freshAthlete->email);
        $this->assertEquals('555-555-5555', $freshAthlete->phone);
        $this->assertEquals('John Doe', $freshAthlete->parent);
        $this->assertEquals('123 Main St', $freshAthlete->street);
        $this->assertEquals('Anytown', $freshAthlete->city);
        $this->assertEquals('CA', $freshAthlete->state);
        $this->assertEquals('12345', $freshAthlete->zip);
        $this->assertEquals('Jane Doe', $freshAthlete->emergencyName);
        $this->assertEquals('Mother', $freshAthlete->emergencyRelationship);
        $this->assertEquals('555-555-5555', $freshAthlete->emergencyPhone);
    }

    #[Test]
    public function an_athlete_can_see_the_swim_team_sign_up_page_by_hash()
    {
        $season = STSeason::factory()->create();
        $level = STLevel::factory()->create();
        $athlete = Athlete::factory()->create(['s_t_level' => $level->id]);

        $this->get(route('swim-team.swimmer.show', ['hash' => $athlete->hash]))
            ->assertOk()
            ->assertSee($athlete->firstName)
            ->assertSee($athlete->lastName)
            ->assertSee($level->name)
            ->assertSee($season->dates)
            ->assertSee('id="athlete_hash" value="'.$athlete->hash.'"', false)
            ->assertSee('id="level_id" value="'.$level->id.'"', false);
    }

    #[Test]
    public function the_swim_team_sign_up_page_returns_a_404_for_a_bad_hash()
    {
        STSeason::factory()->create();

        $this->get(route('swim-team.swimmer.show', ['hash' => 'not-a-real-hash']))
            ->assertNotFound();
    }

    #[Test]
    public function an_athlete_is_charged_the_100_dollar_registration_fee()
    {
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);

        $paymentIntent = $this->createPaymentIntent($athlete);

        $this->assertEquals(10000, $paymentIntent->amount);
        $this->assertEquals('usd', $paymentIntent->currency);
    }

    #[Test]
    public function an_athlete_promo_code_discounts_the_registration_fee()
    {
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);
        $promoCode = PromoCode::factory()->create(['discount_percent' => 25]);

        $paymentIntent = $this->createPaymentIntent($athlete, ['promo_code' => $promoCode->code]);

        $this->assertEquals(7500, $paymentIntent->amount);
    }

    #[Test]
    public function the_athlete_payment_intent_rejects_a_promo_code_that_does_not_exist()
    {
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);

        $this->postJson(route('api.athlete.payment-intent'), [
            'name' => $athlete->firstName.' '.$athlete->lastName,
            'email' => $athlete->email,
            'athlete_hash' => $athlete->hash,
            'level_id' => $athlete->s_t_level,
            'promo_code' => 'not-a-real-code',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['promo_code' => 'The promo code you entered is not valid.']);
    }

    #[Test]
    public function an_athlete_is_registered_once_when_the_payment_page_is_refreshed()
    {
        Mail::fake();

        STSeason::factory()->create();
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);
        $paymentIntent = $this->createPaidPaymentIntent(10000);
        $paymentCompleteUrl = route('swim-team.swimmer.create', ['hash' => $athlete->hash, 'payment_intent' => $paymentIntent->id]);

        $this->get($paymentCompleteUrl)->assertRedirect(route('swim-team.thank-you'));
        $this->get($paymentCompleteUrl)->assertRedirect(route('swim-team.thank-you'));

        $this->assertEquals(1, STSwimmer::where('email', $athlete->email)->count());
        $this->assertStringContainsString($paymentIntent->id, STSwimmer::where('email', $athlete->email)->first()->notes);
        Mail::assertSent(STSignUp::class, 1);
    }

    #[Test]
    public function an_athlete_is_not_registered_when_the_payment_did_not_go_through()
    {
        Mail::fake();

        STSeason::factory()->create();
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);
        $paymentIntent = $this->createUnpaidPaymentIntent(10000);

        $this->get(route('swim-team.swimmer.create', ['hash' => $athlete->hash, 'payment_intent' => $paymentIntent->id]))
            ->assertRedirect(route('swim-team.swimmer.show', ['hash' => $athlete->hash]))
            ->assertSessionHas('error', 'Your payment did not go through. Please try again.');

        $this->assertDatabaseMissing('s_t_swimmers', ['email' => $athlete->email]);
        Mail::assertNothingSent();
    }

    #[Test]
    public function an_athlete_is_not_registered_without_a_real_payment_intent()
    {
        Mail::fake();

        STSeason::factory()->create();
        $athlete = Athlete::factory()->create(['s_t_level' => STLevel::factory()]);
        $signUpPage = route('swim-team.swimmer.show', ['hash' => $athlete->hash]);

        $this->get(route('swim-team.swimmer.create', ['hash' => $athlete->hash]))
            ->assertRedirect($signUpPage)
            ->assertSessionHas('error');

        $this->get(route('swim-team.swimmer.create', ['hash' => $athlete->hash, 'payment_intent' => 'pi_does_not_exist']))
            ->assertRedirect($signUpPage)
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('s_t_swimmers', ['email' => $athlete->email]);
        Mail::assertNothingSent();
    }

    #[Test]
    public function the_athlete_payment_intent_requires_the_athlete_details()
    {
        $this->postJson(route('api.athlete.payment-intent'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'athlete_hash', 'level_id']);
    }

    /**
     * @param  array<string, string>  $extra
     */
    private function createPaymentIntent(Athlete $athlete, array $extra = []): PaymentIntent
    {
        $clientSecret = $this->post(route('api.athlete.payment-intent'), [
            'name' => $athlete->firstName.' '.$athlete->lastName,
            'email' => $athlete->email,
            'athlete_hash' => $athlete->hash,
            'level_id' => $athlete->s_t_level,
            ...$extra,
        ])->assertOk()->json('clientSecret');

        $paymentIntentId = strstr($clientSecret, '_secret_', true);

        return (new StripeClient(config('services.stripe.secret')))->paymentIntents->retrieve($paymentIntentId);
    }
}

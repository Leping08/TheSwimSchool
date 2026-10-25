<?php

namespace Tests\Feature;

use App\Mail\SwimTeam\ReturningSwimmerRegistration;
use App\Mail\SwimTeam\SwimTeamCurrentSwimmerRegistration;
use App\Nova\Actions\SendReturningSwimmerRegistrationEmail;
use App\Nova\Actions\SendSwimTeamRegistrationEmail;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Fields\ActionFields;
use PHPUnit\Framework\Attributes\Test;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Tests\TestCase;

class ReturningSwimmerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_returning_swimmer_email_links_to_the_register_page()
    {
        $swimmer = STSwimmer::factory()->create();

        (new ReturningSwimmerRegistration($swimmer))
            ->assertSeeInHtml(route('swim-team.swimmer.register', ['swimmer' => $swimmer, 'level' => $swimmer->level]));
    }

    #[Test]
    public function the_current_swimmer_email_links_to_the_register_page()
    {
        $swimmer = STSwimmer::factory()->create();

        (new SwimTeamCurrentSwimmerRegistration($swimmer))
            ->assertSeeInHtml(route('swim-team.swimmer.register', ['swimmer' => $swimmer, 'level' => $swimmer->level]));
    }

    #[Test]
    public function the_nova_action_queues_a_returning_swimmer_email_for_each_swimmer()
    {
        Mail::fake();

        $swimmers = STSwimmer::factory()->count(2)->create();

        (new SendReturningSwimmerRegistrationEmail)->handle(new ActionFields(collect(), collect()), $swimmers);

        Mail::assertQueued(ReturningSwimmerRegistration::class, 2);
        foreach ($swimmers as $swimmer) {
            Mail::assertQueued(ReturningSwimmerRegistration::class, fn ($mail) => $mail->hasTo($swimmer->email));
        }
    }

    #[Test]
    public function the_nova_action_queues_a_current_swimmer_email_for_each_swimmer()
    {
        Mail::fake();

        $swimmers = STSwimmer::factory()->count(2)->create();

        (new SendSwimTeamRegistrationEmail)->handle(new ActionFields(collect(), collect()), $swimmers);

        Mail::assertQueued(SwimTeamCurrentSwimmerRegistration::class, 2);
        foreach ($swimmers as $swimmer) {
            Mail::assertQueued(SwimTeamCurrentSwimmerRegistration::class, fn ($mail) => $mail->hasTo($swimmer->email));
        }
    }

    #[Test]
    public function a_returning_swimmer_can_see_the_register_page()
    {
        $season = STSeason::factory()->create();
        $level = STLevel::factory()->create();
        $swimmer = STSwimmer::factory()->create(['s_t_level_id' => $level->id]);

        $this->get(route('swim-team.swimmer.register', ['level' => $level, 'swimmer' => $swimmer]))
            ->assertOk()
            ->assertSee($swimmer->firstName)
            ->assertSee($swimmer->lastName)
            ->assertSee($level->name)
            ->assertSee($season->dates)
            ->assertSee('id="swimmer_id" value="'.$swimmer->id.'"', false)
            ->assertSee('id="level_id" value="'.$level->id.'"', false);
    }

    #[Test]
    public function the_register_page_returns_a_404_for_a_swimmer_that_does_not_exist()
    {
        STSeason::factory()->create();
        $level = STLevel::factory()->create();

        $this->get(route('swim-team.swimmer.register', ['level' => $level, 'swimmer' => 999]))
            ->assertNotFound();
    }

    #[Test]
    public function a_returning_swimmer_can_update_their_details_and_moves_to_the_current_season()
    {
        $oldSeason = STSeason::factory()->create(['current_season' => false]);
        $currentSeason = STSeason::factory()->create();
        $swimmer = STSwimmer::factory()->create(['s_t_season_id' => $oldSeason->id]);

        $this->post('/api/swim-team/swimmer', [
            'swimmerId' => $swimmer->id,
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '555-555-5555',
            'parent' => 'John Doe',
            'street' => '123 Main St',
            'city' => 'Parrish',
            'state' => 'FL',
            'zip' => '34219',
            'emergencyName' => 'John Doe',
            'emergencyRelationship' => 'Dad',
            'emergencyPhone' => '555-555-1234',
        ])->assertOk();

        $swimmer->refresh();
        $this->assertEquals('Jane', $swimmer->firstName);
        $this->assertEquals('Doe', $swimmer->lastName);
        $this->assertEquals('jane@example.com', $swimmer->email);
        $this->assertEquals('123 Main St', $swimmer->street);
        $this->assertEquals('Dad', $swimmer->emergencyRelationship);
        $this->assertEquals($currentSeason->id, $swimmer->s_t_season_id);
    }

    #[Test]
    public function a_returning_swimmer_can_register_with_a_free_promo_code()
    {
        $swimmer = STSwimmer::factory()->create();
        $promoCode = PromoCode::factory()->create(['discount_percent' => 100]);

        $this->post(route('api.swimmer.promo-code.update'), [
            'promo_code' => $promoCode->code,
            'swimmer_id' => $swimmer->id,
        ])->assertOk()
            ->assertJson([
                'success' => true,
                'redirect' => route('swim-team.thank-you'),
            ]);

        $swimmer->refresh();
        $this->assertEquals($promoCode->id, $swimmer->promo_code_id);
        $this->assertStringContainsString($promoCode->code, $swimmer->notes);
    }

    #[Test]
    public function a_returning_swimmer_can_not_skip_payment_with_a_promo_code_under_100_percent()
    {
        $swimmer = STSwimmer::factory()->create();
        $promoCode = PromoCode::factory()->create(['discount_percent' => 50]);

        $this->post(route('api.swimmer.promo-code.update'), [
            'promo_code' => $promoCode->code,
            'swimmer_id' => $swimmer->id,
        ])->assertOk()
            ->assertJson(['success' => false]);

        $this->assertNull($swimmer->refresh()->promo_code_id);
    }

    #[Test]
    public function the_free_promo_code_endpoint_requires_a_promo_code_and_swimmer()
    {
        $this->postJson(route('api.swimmer.promo-code.update'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['promo_code', 'swimmer_id']);
    }

    #[Test]
    public function a_returning_swimmer_is_charged_the_50_dollar_registration_fee()
    {
        $swimmer = STSwimmer::factory()->create();

        $paymentIntent = $this->createPaymentIntent($swimmer);

        $this->assertEquals(5000, $paymentIntent->amount);
        $this->assertEquals('usd', $paymentIntent->currency);
    }

    #[Test]
    public function a_returning_swimmer_promo_code_discounts_the_registration_fee()
    {
        $swimmer = STSwimmer::factory()->create();
        $promoCode = PromoCode::factory()->create(['discount_percent' => 50]);

        $paymentIntent = $this->createPaymentIntent($swimmer, ['promo_code' => $promoCode->code]);

        $this->assertEquals(2500, $paymentIntent->amount);
    }

    #[Test]
    public function the_returning_swimmer_payment_intent_requires_the_swimmer_details()
    {
        $this->postJson('/api/stripe-token/payment-intent/swimmer')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'swimmer_id', 'level_id']);
    }

    /**
     * @param  array<string, string>  $extra
     */
    private function createPaymentIntent(STSwimmer $swimmer, array $extra = []): PaymentIntent
    {
        $clientSecret = $this->post('/api/stripe-token/payment-intent/swimmer', [
            'name' => $swimmer->firstName.' '.$swimmer->lastName,
            'email' => $swimmer->email,
            'swimmer_id' => $swimmer->id,
            'level_id' => $swimmer->s_t_level_id,
            ...$extra,
        ])->assertOk()->json('clientSecret');

        $paymentIntentId = strstr($clientSecret, '_secret_', true);

        return (new StripeClient(config('services.stripe.secret')))->paymentIntents->retrieve($paymentIntentId);
    }
}

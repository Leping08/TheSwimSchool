<?php

namespace Tests\Feature;

use App\Athlete;
use App\Mail\SwimTeam\STSignUp;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class SwimTeamTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test **/
    public function a_swimmer_can_pay_the_registration_fee_by_hitting_the_register_endpoint()
    {
        Mail::fake();
        
        $level = STLevel::factory()->create();
        $season = STSeason::factory()->create();
        $swimmer = STSwimmer::factory()->create([
            's_t_level_id' => $level->id,
            's_t_season_id' => $season->id,
        ]);

        $data = [
            'payment_intent' => 'pi_3LfvfuC1VfPOUMV409eBd2q4',
            'level' => $level->id,
            'swimmer' => $swimmer->id,
        ];

        $this->get(route('swim-team.swimmer.store2', $data))
            ->assertStatus(302);

        $updatedSwimmer = STSwimmer::find($swimmer->id);
        $this->assertStringContainsString('stripe_payment_intent', $updatedSwimmer->notes);
        $this->assertStringContainsString('pi_3LfvfuC1VfPOUMV409eBd2q4', $updatedSwimmer->notes);
        $this->assertStringContainsString('stripe_customer_id', $updatedSwimmer->notes);

        Mail::assertSent(STSignUp::class, 1);
    }

    /** @test **/
    public function an_athlete_can_sign_up_with_a_free_promo_code()
    {
        Mail::fake();
        
        $athlete = Athlete::factory()->create();
        $level = STLevel::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'discount_percent' => 100,
        ]);

        $data = [
            'hash' => $athlete->hash,
            'level_id' => $level->id,
            'promo_code' => $promoCode->code,
        ];

        $this->post(route('api.athlete.promo-code.update', $data))
            ->assertStatus(302);

        // assert the swimmer is created
        $this->assertDatabaseHas('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        Mail::assertSent(STSignUp::class, 1);
    }

    /** @test **/
    public function it_throws_an_error_with_a_bad_hash()
    {
        Mail::fake();
        
        $athlete = Athlete::factory()->create();
        $level = STLevel::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'discount_percent' => 100,
        ]);

        $data = [
            'hash' => "a-bad-hash-that-does-not-exist",
            'level_id' => $level->id,
            'promo_code' => $promoCode->code,
        ];

        $this->post(route('api.athlete.promo-code.update', $data))
            ->assertStatus(500);

        // assert the swimmer is created
        $this->assertDatabaseMissing('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        Mail::assertNothingSent();
    }

    /** @test **/
    public function it_throws_an_error_if_the_promo_is_not_100_percent()
    {
        Mail::fake();
        
        $athlete = Athlete::factory()->create();
        $level = STLevel::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'discount_percent' => 90,
        ]);

        $data = [
            'hash' => $athlete->hash,
            'level_id' => $level->id,
            'promo_code' => $promoCode->code,
        ];

        $this->post(route('api.athlete.promo-code.update', $data))
            ->assertStatus(500);

        // assert the swimmer is created
        $this->assertDatabaseMissing('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        Mail::assertNothingSent();
    }

    /** @test **/
    public function it_throws_an_error_if_the_promo_is_not_valid()
    {
        Mail::fake();
        
        $athlete = Athlete::factory()->create();
        $level = STLevel::factory()->create();

        $data = [
            'hash' => $athlete->hash,
            'level_id' => $level->id,
            'promo_code' => 'not-a-valid-promo-code',
        ];

        $this->post(route('api.athlete.promo-code.update', $data))
            ->assertStatus(500);

        // assert the swimmer is created
        $this->assertDatabaseMissing('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        Mail::assertNothingSent();
    }

    /** @test **/
    public function a_user_can_create_a_payment_intent()
    {
        $athlete = Athlete::factory()->create();
        $level = STLevel::factory()->create();

        $data = [
            'name' => $athlete->firstName . ' ' . $athlete->lastName,
            'email' => $athlete->email,
            'athlete_hash' => $athlete->hash,
            'level_id' => $level->id,
        ];

        $this->post(route('api.athlete.payment-intent', $data))
            ->assertStatus(200)
            ->assertSee('pi_');
    }

    /** @test **/
    public function an_athlete_can_sign_up_as_a_swimmer()
    {
        Mail::fake();

        STSeason::factory()->create();
        $level = STLevel::factory()->create();
        $athlete = Athlete::factory()->create([
            's_t_level' => $level->id,
        ]);

        $this->assertDatabaseMissing('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        $this->get("/swim-team/save-swimmer/athlete/{$athlete->hash}?payment_intent=pi_3LfvfuC1VfPOUMV409eBd2q4")
            ->assertStatus(302);

        // assert the db has the swimmer
        $this->assertDatabaseHas('s_t_swimmers', [
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
        ]);

        Mail::assertSent(STSignUp::class, 1);
    }
}

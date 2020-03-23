<?php

namespace Tests\Feature;

use App\Mail\SwimTeam\STSignUp;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SwimTeamTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    //TODO links in this file are a bit messy

    /** @test **/
    public function a_swimmer_can_sign_up_by_hitting_the_swim_team_sign_up_route()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory(\App\STLevel::class)->create();
        $season = factory(\App\STSeason::class)->create();
        $size = factory(\App\STShirtSize::class)->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
            'shirt_size_id' => $size->id,
            'stripeToken' => 'tok_visa'
        ];


        $this->get("/swim-team/level/{$level->id}/swimmer/")
            ->assertStatus(200);

        $this->assertEquals(0,  \App\STSwimmer::all()->count());

        $response = $this->json('POST', "/swim-team/level/{$level->id}/swimmer/", $attributes);

        $response->assertRedirect('/thank-you');

        Mail::assertSent(STSignUp::class);

        $this->assertEquals(1,  \App\STSwimmer::all()->count());

        $this->assertDatabaseHas('s_t_swimmers', [
            "firstName" => $attributes['firstName'],
            "lastName" => $attributes['lastName'],
            "email" => $attributes['email'],
            "s_t_level_id" => $attributes['level_id'],
            's_t_shirt_size_id' => $attributes['shirt_size_id']
        ]);
    }

    /** @test **/
    public function a_swimmer_can_sign_up_by_hitting_the_swim_team_sign_up_route_with_a_promo_code()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory(\App\STLevel::class)->create([
            'price' => 100
        ]);
        $season = factory(\App\STSeason::class)->create();
        $promoCode = factory(\App\PromoCode::class)->create([
            'code' => 'HALFOFF',
            'discount_percent' => 50
        ]);
        $size = factory(\App\STShirtSize::class)->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
            'shirt_size_id' => $size->id,
            'stripeToken' => 'tok_visa',
            'promo_code' => 'HALFOFF'
        ];

        $this->get("/swim-team/level/{$level->id}/swimmer/")
            ->assertStatus(200);

        $this->assertEquals(0, \App\STSwimmer::all()->count());

        $response = $this->json('POST', "/swim-team/level/{$level->id}/swimmer/", $attributes);

        $response->assertRedirect('/thank-you');

        Mail::assertSent(STSignUp::class);

        $this->assertEquals(1, \App\STSwimmer::all()->count());

        $this->assertDatabaseHas('s_t_swimmers', [
            "firstName" => $attributes['firstName'],
            "lastName" => $attributes['lastName'],
            "email" => $attributes['email'],
            "s_t_level_id" => $attributes['level_id'],
            's_t_shirt_size_id' => $attributes['shirt_size_id'],
            'promo_code_id' => $promoCode->id
        ]);
    }

    /** @test **/
    public function a_swimmer_should_be_able_to_sigh_up_for_free_with_a_promo_code_and_not_hit_stripe()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory(\App\STLevel::class)->create([
            'price' => 100
        ]);
        $season = factory(\App\STSeason::class)->create();
        $promo = factory(\App\PromoCode::class)->create([
            'code' => 'FORFREE',
            'discount_percent' => 100
        ]);
        $size = factory(\App\STShirtSize::class)->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
            'shirt_size_id' => $size->id,
            'stripeToken' => 'tok_visa',
            'promo_code' => $promo->code
        ];

        $this->get("/swim-team/level/{$level->id}/swimmer/")
            ->assertStatus(200);

        $this->assertEquals(0, \App\STSwimmer::all()->count());

        $response = $this->json('POST', "/swim-team/level/{$level->id}/swimmer/", $attributes);

        $response->assertRedirect('/thank-you');

        Mail::assertSent(STSignUp::class);

        $this->assertEquals(1, \App\STSwimmer::all()->count());

        $this->assertDatabaseHas('s_t_swimmers', [
            "firstName" => $attributes['firstName'],
            "lastName" => $attributes['lastName'],
            "email" => $attributes['email'],
            "s_t_level_id" => $attributes['level_id'],
            's_t_shirt_size_id' => $attributes['shirt_size_id'],
            'promo_code_id' => $promo->id,
            'stripeChargeId' => 'For Free Promo Code'
        ]);
    }

    /** @test **/
    public function a_swimmer_can_sign_up_without_a_shirt_size()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory(\App\STLevel::class)->create();
        $season = factory(\App\STSeason::class)->create();
        //$size = factory(\App\STShirtSize::class)->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
            //'shirt_size_id' => $size->id,
            'stripeToken' => 'tok_visa'
        ];


        $this->get("/swim-team/level/{$level->id}/swimmer/")
            ->assertStatus(200);

        $this->assertEquals(0,  \App\STSwimmer::all()->count());

        $response = $this->json('POST', "/swim-team/level/{$level->id}/swimmer/", $attributes);

        $response->assertRedirect('/thank-you');

        Mail::assertSent(STSignUp::class);

        $this->assertEquals(1,  \App\STSwimmer::all()->count());

        $this->assertDatabaseHas('s_t_swimmers', [
            "firstName" => $attributes['firstName'],
            "lastName" => $attributes['lastName'],
            "email" => $attributes['email'],
            "s_t_level_id" => $attributes['level_id'],
            's_t_shirt_size_id' => NULL
        ]);
    }
}

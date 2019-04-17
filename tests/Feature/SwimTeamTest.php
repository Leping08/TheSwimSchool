<?php

namespace Tests\Feature;

use App\Mail\STSignUp;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SwimTeamTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test **/
    public function a_swimmer_can_sign_up_by_hitting_the_swim_team_sign_up_route()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory('App\STLevel')->create();
        $season = factory('App\STSeason')->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
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
            "s_t_level_id" => $attributes['level_id']
        ]);
    }

    /** @test **/
    public function a_swimmer_can_sign_up_by_hitting_the_swim_team_sign_up_route_with_a_promo_code()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $level = factory('App\STLevel')->create([
            'price' => 100
        ]);
        $season = factory('App\STSeason')->create();
        $promoCode = factory('App\PromoCode')->create([
            'code' => 'HALFOFF',
            'discount_percent' => 50
        ]);

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'level_id' => $level->id,
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
            'promo_code_id' => $promoCode->id
        ]);
    }
}

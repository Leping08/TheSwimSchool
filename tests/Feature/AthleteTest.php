<?php

namespace Tests\Feature;

use App\Athlete;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AthleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_hash_is_set_when_an_athlete_is_created()
    {
        $athlete = Athlete::factory()->create();

        $this->assertNotEmpty($athlete->hash);
    }

    /** @test */
    public function a_user_can_update_the_athlete_data_by_hitting_the_api_endpoint()
    {
        $athlete = Athlete::factory()->create();

        $this->post(route('api.athlete.update', $athlete->hash), [
                'firstName' => 'New First Name',
                'lastName' => 'New Last Name',
                'email' => 'testing@gmail.com'
        ]);

        $this->assertEquals('New First Name', $athlete->fresh()->firstName);
        $this->assertEquals('New Last Name', $athlete->fresh()->lastName);
        $this->assertEquals('testing@gmail.com', $athlete->fresh()->email);
    }

    /** @test */
    public function an_update_user_request_must_have_a_matching_hash()
    {
        // Bad hash
        $this->post(route('api.athlete.update', 'fdsafdsafdsa'), [
            'firstName' => 'New First Name',
            'lastName' => 'New Last Name',
            'email' => 'testing@gmail.com'
        ])->assertStatus(404);
    }

    // todo write a test for the stripe payment intent
    // todo write a test for the promo code
    // todo write a test for the new athlete api endpoint
}

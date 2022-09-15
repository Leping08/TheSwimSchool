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
}

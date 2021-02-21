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
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Lesson;

class AthleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_hash_is_set_when_an_athlete_is_created()
    {
        $athlete = factory(\App\Athlete::class)->create();

        $this->assertNotEmpty($athlete->hash);
    }
}

<?php

namespace Tests\Feature;

use App\Lesson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_non_admin_can_not_see_swimmers_in_a_lesson()
    {
        $swimmer = factory(\App\Swimmer::class)->create();
        $lesson = Lesson::first();

        $this->get("/lesson/$lesson->id")
            ->assertDontSee($swimmer->firstName)
            ->assertDontSee($swimmer->lastName);
    }
}

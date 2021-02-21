<?php

namespace Tests\Feature;

use App\Swimmer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Lesson;

class Admin extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_non_admin_can_not_see_swimmers_in_a_lesson()
    {
        $swimmer = Swimmer::factory()->create();
        $lesson = Lesson::first();

        $this->get(route('groups.lessons.show', ['group' => $lesson->group]))
            ->assertDontSee($swimmer->firstName)
            ->assertDontSee($swimmer->lastName);
    }
}

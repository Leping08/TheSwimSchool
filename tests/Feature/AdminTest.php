<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Lesson;

class Admin extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_non_admin_can_not_see_swimmers_in_a_lesson()
    {
        $swimmer = factory(\App\Swimmer::class)->create();
        $lesson = Lesson::first();

        $this->get(route('groups.lessons.show', ['group' => $lesson->group]))
            ->assertDontSee($swimmer->firstName)
            ->assertDontSee($swimmer->lastName);
    }
}

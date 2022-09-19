<?php

namespace Tests\Feature;

use App\Lesson;
use App\Swimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

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

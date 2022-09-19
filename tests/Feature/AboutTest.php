<?php

namespace Tests\Feature;

use App\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_only_see_active_instructors_on_the_about_page()
    {
        $visible_instructor = Instructor::factory()->create();
        $not_visible_instructor = Instructor::factory([
            'active' => false,
        ])->create();

        $this->get(route('pages.about'))
            ->assertSee($visible_instructor->name)
            ->assertDontSee($not_visible_instructor->name);
    }
}

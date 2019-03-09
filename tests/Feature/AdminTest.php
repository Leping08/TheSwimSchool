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
    public function a_admin_can_view_the_dashboard()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSee('Dashboard');
    }

    /** @test */
    public function a_non_admin_can_not_view_the_dashboard()
    {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_admin_can_see_swimmers_in_a_lesson()
    {
        $swimmer = factory(\App\Swimmer::class)->create();
        $lesson = Lesson::first();
        $user = factory(\App\User::class)->create();

        $this->actingAs($user)
            ->get("/lesson/$lesson->id")
            ->assertSee($swimmer->firstName)
            ->assertSee($swimmer->lastName);
    }

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

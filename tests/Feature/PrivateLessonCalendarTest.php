<?php


namespace Tests\Feature;


use App\PrivatePoolSession;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrivateLessonCalendarTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_can_only_sign_up_for_a_private_lesson_that_is_available()
    {
        $this->seed();

        $next_week = factory(PrivatePoolSession::class)->create([
            'start' => Carbon::now()->addWeek(),
            'end' => Carbon::now()->addWeek()->addHour(),
            'private_lesson_id' => null
        ]);

        $last_week = factory(PrivatePoolSession::class)->create([
            'start' => Carbon::now()->subWeek(),
            'end' => Carbon::now()->subWeek()->subHour(),
            'private_lesson_id' => null
        ]);

        $this->get(route('private_lesson.index'))
            ->assertStatus(200)
            ->assertSee($next_week->start->toJSON())
            ->assertDontSee($last_week->start->toJSON());
    }
}
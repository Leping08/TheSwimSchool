<?php

namespace Tests\Feature;

use App\Instructor;
use App\Lesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorCalendarTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function only_an_admin_can_visit_the_instructor_calendar_page()
    {
        $user = User::factory()->create();
        $instructor = Instructor::factory()->create();

        $this->get(route('calendar', ['instructor' => $instructor]))
            ->assertStatus(302);

        $this->actingAs($user);

        $this->get(route('calendar', ['instructor' => $instructor]))
            ->assertStatus(200);
    }

    /** @test  **/
    public function the_calendar_page_shows_lessons_only_for_the_instructor_calendar_being_looked_at()
    {
        $this->runDatabaseMigrations();
        $this->seed();

        $user_1 = User::factory()->create();
        $instructor_1 = Instructor::factory()->create();

        $user_2 = User::factory()->create();
        $instructor_2 = Instructor::factory()->create();

        $lesson_1 = Lesson::factory()->create([
            'instructor_id' => $instructor_1->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3',
        ]);
        $lesson_1->DaysOfTheWeek()->sync(explode(',', $lesson_1->days));

        $lesson_2 = Lesson::factory()->create([
            'instructor_id' => $instructor_2->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3',
        ]);
        $lesson_2->DaysOfTheWeek()->sync(explode(',', $lesson_2->days));

        $this->actingAs($user_1);
        $this->get(route('calendar', ['instructor' => $instructor_1]))
            ->assertStatus(200)
            ->assertSee($lesson_1->group->type)
            ->assertDontSee($lesson_2->group->type);

        $this->actingAs($user_2);
        $this->get(route('calendar', ['instructor' => $instructor_2]))
            ->assertStatus(200)
            ->assertSee($lesson_2->group->type)
            ->assertDontSee($lesson_1->group->type);
    }

    /** @test  **/
    public function the_calendar_will_not_show_lessons_older_then_3_months_ago()
    {
        $this->runDatabaseMigrations();
        $this->seed();

        $user = User::factory()->create();
        $instructor = Instructor::factory()->create();

        $lesson_1 = Lesson::factory()->create([
            'instructor_id' => $instructor->id,
            'class_start_date' => Carbon::now()->subWeek(),
            'class_end_date' => Carbon::now()->addWeek(),
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3',
        ]);
        $lesson_1->DaysOfTheWeek()->sync(explode(',', $lesson_1->days));

        $lesson_2 = Lesson::factory()->create([
            'instructor_id' => $instructor->id,
            'class_start_date' => Carbon::now()->subMonths(4),
            'class_end_date' => Carbon::now()->subDays(100), //Around 3 months
            'class_start_time' => Carbon::now(),
            'class_end_time' => Carbon::now()->addHour(),
            'days' => '1,3',
        ]);
        $lesson_2->DaysOfTheWeek()->sync(explode(',', $lesson_2->days));

        $this->actingAs($user);
        $this->get(route('calendar', ['instructor' => $instructor]))
            ->assertStatus(200)
            ->assertSee($lesson_1->group->type)
            ->assertDontSee($lesson_2->group->type);
    }

    /** @test  **/
    public function the_calendar_will_show_the_correct_number_of_events_for_a_lesson()
    {
        $this->runDatabaseMigrations();
        $this->seed();

        $instructor = User::factory()->create();

        $lesson_1 = Lesson::factory()->create([
            'instructor_id' => $instructor->id,
            'class_start_date' => Carbon::parse('2020-06-01'),
            'class_end_date' => Carbon::parse('2020-06-11'),
            'class_start_time' => Carbon::parse('2020-06-01 9:30:00 AM'),
            'class_end_time' => Carbon::parse('2020-06-01 10:00:00 AM'),
            'days' => '1,2,3,4',
        ]);

        $lesson_1->DaysOfTheWeek()->sync(explode(',', $lesson_1->days));

        $this->assertCount(8, $lesson_1->calendarEvents);
    }
}

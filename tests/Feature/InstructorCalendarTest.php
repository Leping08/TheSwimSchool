<?php

namespace Tests\Feature;

use App\Group;
use App\Instructor;
use App\Lesson;
use App\Location;
use App\PoolSession;
use App\PrivateLesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorCalendarTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function test()
    {
        // dump the app environment
        // dump(config('app.env'));
        // dump(config('database.connections'));
        dump(env('APP_ENV'));
    }

    // /** @test  **/
    // public function only_an_admin_can_visit_the_instructor_calendar_page()
    // {
    //     $user = User::factory()->create();
    //     $instructor = Instructor::factory()->create();

    //     $this->get(route('calendar', ['instructor' => $instructor]))
    //         ->assertStatus(302);

    //     $this->actingAs($user);

    //     $this->get(route('calendar', ['instructor' => $instructor]))
    //         ->assertStatus(200);
    // }

    // /** @test  **/
    // public function the_calendar_page_shows_lessons_only_for_the_instructor_calendar_being_looked_at()
    // {
    //     $this->seed();

    //     $user_1 = User::factory()->create();
    //     $instructor_1 = Instructor::factory()->create();

    //     $user_2 = User::factory()->create();
    //     $instructor_2 = Instructor::factory()->create();

    //     $lesson_1 = Lesson::factory()->create([
    //         'instructor_id' => $instructor_1->id,
    //         'class_start_date' => Carbon::now()->subWeek(),
    //         'class_end_date' => Carbon::now()->addWeek(),
    //         'class_start_time' => Carbon::now(),
    //         'class_end_time' => Carbon::now()->addHour(),
    //         'days' => [
    //             '1' => true,
    //             '3' => true,
    //         ],
    //     ]);

    //     $lesson_2 = Lesson::factory()->create([
    //         'instructor_id' => $instructor_2->id,
    //         'class_start_date' => Carbon::now()->subWeek(),
    //         'class_end_date' => Carbon::now()->addWeek(),
    //         'class_start_time' => Carbon::now(),
    //         'class_end_time' => Carbon::now()->addHour(),
    //         'days' => [
    //             '1' => true,
    //             '3' => true,
    //         ],
    //     ]);

    //     $this->actingAs($user_1);
    //     $this->get(route('calendar', ['instructor' => $instructor_1]))
    //         ->assertStatus(200)
    //         ->assertSee($lesson_1->group->type)
    //         ->assertDontSee($lesson_2->group->type);

    //     $this->actingAs($user_2);
    //     $this->get(route('calendar', ['instructor' => $instructor_2]))
    //         ->assertStatus(200)
    //         ->assertSee($lesson_2->group->type)
    //         ->assertDontSee($lesson_1->group->type);
    // }

    // /** @test  **/
    // public function the_calendar_will_not_show_lessons_older_then_3_months_ago()
    // {
    //     $this->seed();

    //     $user = User::factory()->create();
    //     $instructor = Instructor::factory()->create();

    //     $group1 = Group::factory()->create([
    //         'type' => 'Star Fish',
    //     ]);

    //     $group2 = Group::factory()->create([
    //         'type' => 'Dolphin',
    //     ]);

    //     $lesson_1 = Lesson::factory()->create([
    //         'group_id' => $group1->id,
    //         'instructor_id' => $instructor->id,
    //         'class_start_date' => Carbon::now()->subWeek(),
    //         'class_end_date' => Carbon::now()->addWeek(),
    //         'class_start_time' => Carbon::now(),
    //         'class_end_time' => Carbon::now()->addHour(),
    //         'days' => [
    //             '1' => true,
    //             '3' => true,
    //         ],
    //     ]);

    //     $lesson_2 = Lesson::factory()->create([
    //         'group_id' => $group2->id,
    //         'instructor_id' => $instructor->id,
    //         'class_start_date' => Carbon::now()->subMonths(4),
    //         'class_end_date' => Carbon::now()->subMonths(4)->addWeek(),
    //         'class_start_time' => Carbon::now(),
    //         'class_end_time' => Carbon::now()->addHour(),
    //         'days' => [
    //             '1' => true,
    //             '3' => true,
    //         ],
    //     ]);

    //     $this->actingAs($user);
    //     $this->get(route('calendar', ['instructor' => $instructor]))
    //         ->assertStatus(200)
    //         ->assertSee($group1->type)
    //         ->assertDontSee($group2->type);
    // }

    // /** @test  **/
    // public function the_calendar_will_show_the_correct_number_of_events_for_a_lesson()
    // {
    //     $this->seed();

    //     $instructor = User::factory()->create();

    //     $lesson_1 = Lesson::factory()->create([
    //         'instructor_id' => $instructor->id,
    //         'class_start_date' => Carbon::parse('2020-06-01'),
    //         'class_end_date' => Carbon::parse('2020-06-11'),
    //         'class_start_time' => Carbon::parse('2020-06-01 9:30:00 AM'),
    //         'class_end_time' => Carbon::parse('2020-06-01 10:00:00 AM'),
    //         'days' => [
    //             '1' => true,
    //             '2' => true,
    //             '3' => true,
    //             '4' => true,
    //         ],
    //     ]);

    //     $this->assertCount(8, $lesson_1->calendarEvents);
    // }

    // /** @test  **/
    // public function it_will_show_private_lessons()
    // {
    //     $this->seed();

    //     $user = User::factory()->create();
    //     $instructor = Instructor::factory()->create();
    //     $location = Location::factory()->create();

    //     $private_lesson = PrivateLesson::factory()->create();

    //     PoolSession::factory()->create([
    //         'pool_session_id' => $private_lesson->id,
    //         'pool_session_type' => PrivateLesson::class,
    //         'instructor_id' => $instructor->id,
    //         'location_id' => $location->id,
    //         'start' => Carbon::tomorrow(),
    //         'end' => Carbon::tomorrow()->addHour(),
    //     ]);

    //     PoolSession::factory()->create([
    //         'pool_session_id' => $private_lesson->id,
    //         'pool_session_type' => PrivateLesson::class,
    //         'instructor_id' => $instructor->id,
    //         'location_id' => $location->id,
    //         'start' => Carbon::now()->addHour(),
    //         'end' => Carbon::now()->addHours(2),
    //     ]);

    //     $this->assertCount(2, PoolSession::all());

    //     $this->actingAs($user);
    //     $this->get(route('calendar', ['instructor' => $instructor]))
    //         ->assertStatus(200)
    //         ->assertSee($location->name)
    //         ->assertSee($instructor->name)
    //         ->assertSee('Private');
    // }

    // /** @test  **/
    // public function it_will_only_show_private_lessons_from_3_months_ago_and_onward()
    // {
    //     $this->seed();

    //     $user = User::factory()->create();
    //     $instructor = Instructor::factory()->create();
    //     $location = Location::factory()->create();

    //     $private_lesson = PrivateLesson::factory()->create();

    //     PoolSession::factory()->create([
    //         'pool_session_id' => $private_lesson->id,
    //         'pool_session_type' => PrivateLesson::class,
    //         'instructor_id' => $instructor->id,
    //         'location_id' => $location->id,
    //         'start' => Carbon::tomorrow(),
    //         'end' => Carbon::tomorrow()->addHour(),
    //     ]);

    //     // Poolsession over 3 months old
    //     PoolSession::factory()->create([
    //         'pool_session_id' => $private_lesson->id,
    //         'pool_session_type' => PrivateLesson::class,
    //         'instructor_id' => $instructor->id,
    //         'location_id' => $location->id,
    //         'start' => Carbon::now()->subMonths(4),
    //         'end' => Carbon::now()->subMonths(4)->addHour(1),
    //     ]);

    //     $this->assertCount(2, PoolSession::all());

    //     $calendarSessions = PoolSession::where('instructor_id', $instructor->id)
    //         ->privateLessonsSignedUp()
    //         ->whereDate('start', '>=', Carbon::now()->subMonths(3))
    //         ->with(['lesson.swimmer', 'location'])
    //         ->get();

    //     $this->assertCount(1, $calendarSessions);

    //     $this->actingAs($user);
    //     $this->get(route('calendar', ['instructor' => $instructor]))
    //         ->assertStatus(200)
    //         ->assertSee($location->name)
    //         ->assertSee($instructor->name)
    //         ->assertSee('Private');
    // }
}

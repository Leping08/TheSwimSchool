<?php

namespace Tests\Feature;

use App\Group;
use App\Lesson;
use App\PoolSession;
use App\PrivateLesson;
use App\PrivateSwimmer;
use App\Swimmer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RealhabAttendanceTest extends TestCase
{
    use DatabaseMigrations;

    #[Test]
    public function only_admins_can_see_the_realhab_attendance_page()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('realhab-attendance.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->actingAs($user);

        $this->get(route('realhab-attendance.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function the_realhab_attendance_page_shows_the_correct_group_data()
    {
        $this->seed();

        $this->actingAs(User::factory()->create());

        // Create a group lesson that has pool sessions in the past and future
        $group = Group::factory()->create();
        $lesson = Lesson::factory()->create([
            'group_id' => $group->id,
            'class_start_date' => now()->subWeek(),
            'class_end_date' => now()->addWeek(),
            'class_start_time' => now(),
            'class_end_time' => now()->addHour(),
            'days' => [
                '1' => true,
                '3' => true,
            ],
        ]);

        // Create a pool session for the group lesson
        $poolSession = PoolSession::factory()->create([
            'location_id' => 63,
            'pool_session_type' => Lesson::class,
            'pool_session_id' => $lesson->id,
            'start' => now(),
            'end' => now()->addHour(),
        ]);

        // Create a swimmer to add to the pool session
        $swimmer = Swimmer::factory()->create();

        // Add a swimmer to the pool session
        $poolSession->attendances()->create([
            'swimmable_id' => $swimmer->id,
            'swimmable_type' => Swimmer::class,
            'attended' => true,
        ]);

        $response = $this->get(route('realhab-attendance.index', [
            'start' => now()->subWeek()->format('Y-m-d'),
            'end' => now()->addWeek()->format('Y-m-d'),
            'type' => 'group',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('lessons.realhab-attendance');
        $response->assertViewHasAll([
            'sessions',
            'swimmers',
        ]);
        // Assert see swimmer name
        $response->assertSee($swimmer->name);
    }

    #[Test]
    public function is_will_not_show_a_swimmer_that_has_not_attended_a_pool_session()
    {
        $this->seed();

        $this->actingAs(User::factory()->create());

        // Create a group lesson that has pool sessions in the past and future
        $group = Group::factory()->create();
        $lesson = Lesson::factory()->create([
            'group_id' => $group->id,
            'class_start_date' => now()->subWeek(),
            'class_end_date' => now()->addWeek(),
            'class_start_time' => now(),
            'class_end_time' => now()->addHour(),
            'days' => [
                '1' => true,
                '3' => true,
            ],
        ]);

        // Create a pool session for the group lesson
        $poolSession = PoolSession::factory()->create([
            'location_id' => 63,
            'pool_session_type' => Lesson::class,
            'pool_session_id' => $lesson->id,
            'start' => now(),
            'end' => now()->addHour(),
        ]);

        // Create a swimmer to add to the pool session
        $swimmer = Swimmer::factory()->create();

        // Add a swimmer to the pool session
        $poolSession->attendances()->create([
            'swimmable_id' => $swimmer->id,
            'swimmable_type' => Swimmer::class,
            'attended' => false,
        ]);

        $response = $this->get(route('realhab-attendance.index', [
            'start' => now()->subWeek()->format('Y-m-d'),
            'end' => now()->addWeek()->format('Y-m-d'),
            'type' => 'group',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('lessons.realhab-attendance');
        $response->assertViewHasAll([
            'sessions',
            'swimmers',
        ]);
        // Assert see swimmer name
        $response->assertDontSee($swimmer->name);
    }

    #[Test]
    public function the_realhab_attendance_page_shows_the_correct_private_data()
    {
        $this->seed();

        $this->actingAs(User::factory()->create());

        // Create a private lesson that has pool sessions in the past and future
        $privateLesson = PrivateLesson::factory()->create();

        // Create a pool session for the private lesson
        $poolSession = PoolSession::factory()->create([
            'location_id' => 63,
            'pool_session_type' => PrivateLesson::class,
            'pool_session_id' => $privateLesson->id,
            'start' => now(),
            'end' => now()->addHour(),
        ]);

        // Create a swimmer to add to the pool session
        $privateSwimmer = PrivateSwimmer::factory()->create();

        // Add a swimmer to the pool session
        $poolSession->attendances()->create([
            'swimmable_id' => $privateSwimmer->id,
            'swimmable_type' => PrivateSwimmer::class,
            'attended' => true,
        ]);

        $response = $this->get(route('realhab-attendance.index', [
            'start' => now()->subWeek()->format('Y-m-d'),
            'end' => now()->addWeek()->format('Y-m-d'),
            'type' => 'private',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('lessons.realhab-attendance');
        $response->assertViewHasAll([
            'sessions',
            'swimmers',
        ]);
        // Assert see swimmer name
        $response->assertSee($privateSwimmer->name);
    }
}

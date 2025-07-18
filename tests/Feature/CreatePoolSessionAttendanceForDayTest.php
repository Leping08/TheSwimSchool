<?php

namespace Tests\Feature;

use App\Jobs\CreatePoolSessionAttendanceForDay;
use App\Lesson;
use App\PoolSession;
use App\PoolSessionAttendance;
use App\Swimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatePoolSessionAttendanceForDayTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function running_the_create_pool_sessionattendance_for_day_job_does_create_pool_sessions_for_date()
    {
        $this->seed();

        $this->assertCount(0, PoolSession::all());

        // Create a lesson that starts today
        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2020-06-01'),
            'class_end_date' => Carbon::parse('2020-06-11'),
            'class_start_time' => Carbon::parse('2020-06-01 9:30:00 AM'),
            'class_end_time' => Carbon::parse('2020-06-01 10:00:00 AM'),
            'days' => [
                '1' => true,
                '2' => true,
                '3' => true,
                '4' => true,
            ],
        ]);

        Swimmer::factory()->count(4)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertCount(8, PoolSession::all());

        $this->assertCount(0, PoolSessionAttendance::all());

        CreatePoolSessionAttendanceForDay::dispatchSync(Carbon::parse('2020-06-01'));

        $this->assertCount(4, PoolSessionAttendance::all());
    }

    #[Test]
    public function it_only_creates_the_pool_session_attendance_for_that_day()
    {
        $this->seed();

        $this->assertCount(0, PoolSession::all());

        // Create a lesson that starts today
        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2020-06-01'),
            'class_end_date' => Carbon::parse('2020-06-11'),
            'class_start_time' => Carbon::parse('2020-06-01 9:30:00 AM'),
            'class_end_time' => Carbon::parse('2020-06-01 10:00:00 AM'),
            'days' => [
                '1' => true,
                '2' => true,
                '3' => true,
                '4' => true,
            ],
        ]);

        Swimmer::factory()->count(4)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertCount(8, PoolSession::all());

        $this->assertCount(0, PoolSessionAttendance::all());

        CreatePoolSessionAttendanceForDay::dispatchSync(Carbon::parse('2020-06-07'));

        $this->assertCount(0, PoolSessionAttendance::all());
    }

    #[Test]
    public function it_will_not_create_duplicate_pool_session_attendance_for_that_day()
    {
        $this->seed();

        $this->assertCount(0, PoolSession::all());

        // Create a lesson that starts today
        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2020-06-01'),
            'class_end_date' => Carbon::parse('2020-06-11'),
            'class_start_time' => Carbon::parse('2020-06-01 9:30:00 AM'),
            'class_end_time' => Carbon::parse('2020-06-01 10:00:00 AM'),
            'days' => [
                '1' => true,
                '2' => true,
                '3' => true,
                '4' => true,
            ],
        ]);

        Swimmer::factory()->count(4)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertCount(8, PoolSession::all());

        $this->assertCount(0, PoolSessionAttendance::all());

        CreatePoolSessionAttendanceForDay::dispatchSync(Carbon::parse('2020-06-01'));

        $this->assertCount(4, PoolSessionAttendance::all());

        CreatePoolSessionAttendanceForDay::dispatchSync(Carbon::parse('2020-06-01'));

        $this->assertCount(4, PoolSessionAttendance::all());
    }
}

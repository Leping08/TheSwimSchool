<?php

namespace Tests\Unit;

use App\Group;
use App\Lesson;
use App\Location;
use App\PoolSession;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_have_enough_swimmers_that_makes_it_full()
    {
        $lesson = Lesson::factory()->create([
            'class_size' => 2,
        ]);

        $this->assertEquals(false, $lesson->isFull());

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(false, $lesson->isFull());

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(true, $lesson->isFull());
    }

    #[Test]
    public function it_has_swimmers()
    {
        $lesson = Lesson::factory()->create();

        $this->assertEquals(false, $lesson->hasSwimmers());

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(true, $lesson->hasSwimmers());
    }

    #[Test]
    public function it_can_be_private()
    {
        $group = Group::factory()->create([
            'type' => 'Star Fish',
        ]);

        $lesson = Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        $this->assertEquals(false, $lesson->isPrivate());

        $group->update([
            'type' => 'Private',
        ]);

        $lesson = $lesson->fresh();

        $this->assertEquals(true, $lesson->isPrivate());
    }

    #[Test]
    public function it_sets_the_days_when_created()
    {
        Artisan::call('db:seed');

        $lesson = Lesson::factory()->create([
            'days' => [
                '1' => true, // Monday
                '2' => true, // Tuesday
                '3' => true, // Wednesday
            ],
        ]);

        $lesson = $lesson->fresh();

        $this->assertEquals(3, $lesson->daysOfTheWeek->count());
    }

    #[Test]
    public function it_creates_pool_sessions_when_created()
    {
        Artisan::call('db:seed');

        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2021-01-01'),
            'class_end_date' => Carbon::parse('2021-01-14'),
            'days' => [
                '1' => true, // Monday
                '2' => true, // Tuesday
                '3' => true, // Wednesday
            ],
        ]);

        $this->assertEquals(6, $lesson->pool_sessions->count());
    }

    #[Test]
    public function it_has_pool_sessions()
    {
        $lesson = Lesson::factory()->create();
        $poolSession = PoolSession::factory()->create([
            'pool_session_id' => $lesson->id,
            'pool_session_type' => Lesson::class,
        ]);

        $this->assertEquals(1, $lesson->pool_sessions->count());
        $this->assertEquals($poolSession->id, $lesson->pool_sessions->first()->id);
    }

    // Test to see if it wont create the same pool sessions
    // twice if the lesson->generatePoolSessions is called again
    #[Test]
    public function it_wont_create_the_same_pool_sessions_twice()
    {
        Artisan::call('db:seed');

        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2021-01-01'),
            'class_end_date' => Carbon::parse('2021-01-14'),
            'days' => [
                '1' => true, // Monday
                '2' => true, // Tuesday
                '3' => true, // Wednesday
            ],
        ]);

        $this->assertEquals(6, $lesson->pool_sessions->count());

        $lesson->generatePoolSessions([]);

        $this->assertEquals(6, $lesson->pool_sessions->count());
    }

    #[Test]
    public function it_will_update_the_location_on_all_pool_sessions_if_the_location_is_changed_on_the_lesson()
    {
        $location_1 = Location::factory()->create();
        $location_2 = Location::factory()->create();

        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2021-01-01'),
            'class_end_date' => Carbon::parse('2021-01-14'),
            'location_id' => $location_1->id,
            'days' => [
                '1' => true, // Monday
                '2' => true, // Tuesday
                '3' => true, // Wednesday
            ],
        ]);

        $this->assertEquals(6, $lesson->pool_sessions->count());

        $lesson->update([
            'location_id' => $location_2->id,
        ]);

        $this->assertEquals(6, $lesson->pool_sessions->count());

        $poolSessions = $lesson->pool_sessions->fresh();

        $poolSessions->each(function ($poolSession) use ($lesson) {
            $this->assertEquals($lesson->location_id, $poolSession->location_id);
        });
    }

    #[Test]
    public function it_will_delete_all_pool_sessions_when_the_lesson_is_deleted()
    {
        $location = Location::factory()->create();

        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::parse('2021-01-01'),
            'class_end_date' => Carbon::parse('2021-01-14'),
            'location_id' => $location->id,
            'days' => [
                '1' => true, // Monday
                '2' => true, // Tuesday
                '3' => true, // Wednesday
            ],
        ]);

        $this->assertEquals(6, $lesson->pool_sessions->count());

        $lesson->delete();

        $this->assertEquals(0, PoolSession::count());
    }
}

<?php

namespace Tests\Unit;

use App\Lesson;
use App\PoolSession;
use App\PrivateLesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PoolSessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function test_it_can_be_for_a_private_lesson()
    {
        $privateLesson = PrivateLesson::factory()->create();
        $poolSession = PoolSession::factory()->create([
            'pool_session_id' => $privateLesson->id,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $this->assertEquals($privateLesson->id, $poolSession->pool_sessionable->id);
        $this->assertEquals(PrivateLesson::class, $poolSession->pool_sessionable->getMorphClass());
    }

    /** @test  **/
    public function test_it_can_be_for_a_group_lesson()
    {
        $groupLesson = Lesson::factory()->create();
        $poolSession = PoolSession::factory()->create([
            'pool_session_id' => $groupLesson->id,
            'pool_session_type' => Lesson::class,
        ]);

        $this->assertEquals($groupLesson->id, $poolSession->pool_sessionable->id);
        $this->assertEquals(Lesson::class, $poolSession->pool_sessionable->getMorphClass());
    }

    /** @test  **/
    public function a_private_lesson_can_have_many_pool_sessions()
    {
        $privateLesson = PrivateLesson::factory()->create();
        $poolSession1 = PoolSession::factory()->create([
            'pool_session_id' => $privateLesson->id,
            'pool_session_type' => PrivateLesson::class,
        ]);
        $poolSession2 = PoolSession::factory()->create([
            'pool_session_id' => $privateLesson->id,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $this->assertEquals($privateLesson->id, $poolSession1->pool_sessionable->id);
        $this->assertEquals($privateLesson->id, $poolSession2->pool_sessionable->id);
        $pool_sessions = $privateLesson->pool_sessions;
        $this->assertEquals(2, $pool_sessions->count());
        $this->assertEquals($poolSession1->id, $pool_sessions[0]->id);
        $this->assertEquals($poolSession2->id, $pool_sessions[1]->id);
    }

    /** @test  **/
    public function a_group_lesson_can_have_many_pool_sessions()
    {
        $groupLesson = Lesson::factory()->create();
        $poolSession1 = PoolSession::factory()->create([
            'pool_session_id' => $groupLesson->id,
            'pool_session_type' => Lesson::class,
        ]);
        $poolSession2 = PoolSession::factory()->create([
            'pool_session_id' => $groupLesson->id,
            'pool_session_type' => Lesson::class,
        ]);

        $this->assertEquals($groupLesson->id, $poolSession1->pool_sessionable->id);
        $this->assertEquals($groupLesson->id, $poolSession2->pool_sessionable->id);
        $pool_sessions = $groupLesson->pool_sessions;
        $this->assertEquals(2, $pool_sessions->count());
        $this->assertEquals($poolSession1->id, $pool_sessions[0]->id);
        $this->assertEquals($poolSession2->id, $pool_sessions[1]->id);
    }

    /** @test  **/
    public function a_pool_session_is_created_when_a_group_lesson_is_created()
    {
        $groupLesson = Lesson::factory()->create([
            'registration_open' => now()->subDay(),
            'class_start_date' => Carbon::parse('04/22/2024'), // Monday
            'class_start_time' => Carbon::parse('04/22/2024')->setHour(9)->setMinute(0),
            'class_end_date' => Carbon::parse('04/29/2024'), // Monday the following week
            'class_end_time' => Carbon::parse('04/22/2024')->setHour(10)->setMinute(0),
            'days' => [
                '1' => false,
                '2' => true,
                '3' => true,
                '4' => false,
                '5' => false,
                '6' => false,
                '7' => false
            ]
        ]);

        $poolSession = PoolSession::where('pool_session_id', $groupLesson->id)
            ->where('pool_session_type', Lesson::class)
            ->get();

        $this->assertNotNull($poolSession);
        $this->assertEquals(2, $poolSession->count());
    }
}

<?php

namespace Tests\Unit;

use App\Instructor;
use App\Location;
use App\Nova\Actions\CreatePoolSessionsForPrivateLessons;
use App\PoolSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Nova\Fields\ActionFields;
use Tests\TestCase;

class PrivatePoolSessionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_pool_sessions_when_a_private_lesson_is_creted()
    {
        $this->seed();

        $privateLesson = \App\PrivateLesson::factory()->create();
        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePoolSessionsForPrivateLessons());
        $fields = collect([
            "start_date_time" => "2022-04-10T08:00:00.000-04:00",
            "end_date_time" => "2022-04-16T09:00:00.000-04:00",
            "days" => [
                '1' => true, // '1' is Monday
                '2' => true, // '2' is Tuesday
                '3' => false, // '3' is Wednesday
                '4' => false, // '4' is Thursday
                '5' => false, // '5' is Friday
                '6' => false, // '6' is Saturday
                '7' => false, // '7' is Sunday
            ],
            "location_id" => $location->id,
            "instructor_id" => $instructor->id
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(2, PoolSession::all());
    }

    /** @test */
    public function it_should_create_a_weeks_worth_of_pool_sessions()
    {

        $this->seed();

        $privateLesson = \App\PrivateLesson::factory()->create();
        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePoolSessionsForPrivateLessons());
        $fields = collect([
            "start_date_time" => "2022-04-10T08:00:00.000-04:00",
            "end_date_time" => "2022-04-16T09:00:00.000-04:00",
            "days" => [
                '1' => true, // '1' is Monday
                '2' => true, // '2' is Tuesday
                '3' => true, // '3' is Wednesday
                '4' => true, // '4' is Thursday
                '5' => true, // '5' is Friday
                '6' => true, // '6' is Saturday
                '7' => true, // '7' is Sunday
            ],
            "location_id" => $location->id,
            "instructor_id" => $instructor->id
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(7, PoolSession::all());
    }

    /** @test */
    public function it_should_create_multiple_weeks_worth_of_pool_sessions()
    {
        $this->seed();

        $privateLesson = \App\PrivateLesson::factory()->create();
        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePoolSessionsForPrivateLessons());
        $fields = collect([
            "start_date_time" => "2022-04-04T08:00:00.000-04:00",
            "end_date_time" => "2022-04-15T09:00:00.000-04:00",
            "days" => [
                '2' => true, // '2' is Tuesday
                '5' => true, // '5' is Friday
            ],
            "location_id" => $location->id,
            "instructor_id" => $instructor->id
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(4, PoolSession::all());
    }

    /** @test */
    public function it_should_not_create_the_same_pool_sessions_twice()
    {
        $this->seed();

        $privateLesson = \App\PrivateLesson::factory()->create();
        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePoolSessionsForPrivateLessons());
        $fields = collect([
            "start_date_time" => "2022-04-04T08:00:00.000-04:00",
            "end_date_time" => "2022-04-15T09:00:00.000-04:00",
            "days" => [
                '2' => true, // '2' is Tuesday
                '5' => true, // '5' is Friday
            ],
            "location_id" => $location->id,
            "instructor_id" => $instructor->id
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(4, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(4, PoolSession::all());
    }

    /** @test */
    public function it_sets_the_price_for_all_the_pool_sessions_being_created()
    {
        $this->seed();

        $privateLesson = \App\PrivateLesson::factory()->create();
        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePoolSessionsForPrivateLessons());
        $fields = collect([
            "start_date_time" => "2022-04-10T08:00:00.000-04:00",
            "end_date_time" => "2022-04-16T09:00:00.000-04:00",
            "price" => 35,
            "days" => [
                '1' => true, // '1' is Monday
                '2' => true, // '2' is Tuesday
                '3' => true, // '3' is Wednesday
                '4' => true, // '4' is Thursday
                '5' => true, // '5' is Friday
                '6' => true, // '6' is Saturday
                '7' => true, // '7' is Sunday
            ],
            "location_id" => $location->id,
            "instructor_id" => $instructor->id
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(7, PoolSession::all());

        // Assert that all pool sessions have the price of 35
        PoolSession::all()->each(function ($poolSession) {
            $this->assertEquals(35, $poolSession->price);
        });
    }
}

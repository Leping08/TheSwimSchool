<?php

namespace Tests\Feature;

use App\Instructor;
use App\Location;
use App\Nova\Actions\CreatePrivate;
use App\PrivatePoolSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Nova\Fields\ActionFields;
use Tests\TestCase;

class PrivatePoolSessionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_private_pool_sessions_when_a_private_pool()
    {
        $this->seed();

        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePrivate());
        $fields = collect([
            "start_date_time" => "2022-04-10T08:00:00.000-04:00",
            "end_date_time" => "2022-04-16T09:00:00.000-04:00",
            "days" => "1,2", // '3,4,5' is wednesday, thursday, friday
            "location" => $location,
            "instructor" => $instructor,
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PrivatePoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(2, PrivatePoolSession::all());
    }

    /** @test */
    public function it_should_create_a_weeks_worth_of_lessons()
    {

        $this->seed();

        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePrivate());
        $fields = collect([
            "start_date_time" => "2022-04-10T08:00:00.000-04:00",
            "end_date_time" => "2022-04-16T09:00:00.000-04:00",
            "days" => "1,2,3,4,5,6,7",
            "location" => $location,
            "instructor" => $instructor,
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PrivatePoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(7, PrivatePoolSession::all());
    }

    /** @test */
    public function it_should_create_multiple_weeks_worth_of_lessons()
    {
        $this->seed();

        $instructor = Instructor::factory()->create();
        $location = Location::factory()->create();

        $private = (new CreatePrivate());
        $fields = collect([
            "start_date_time" => "2022-04-04T08:00:00.000-04:00",
            "end_date_time" => "2022-04-15T09:00:00.000-04:00",
            "days" => "2,5",
            "location" => $location,
            "instructor" => $instructor,
        ]);

        $action = new ActionFields($fields, collect());

        $this->assertCount(0, PrivatePoolSession::all());

        $private->handle($action, collect());

        $this->assertCount(4, PrivatePoolSession::all());
    }
}

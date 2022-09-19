<?php

namespace Tests\Feature;

use App\PrivatePoolSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivatePoolSessionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_private_pool_sessions_when_a_private_pool()
    {
        $this->seed();

        $this->assertCount(0, PrivatePoolSession::all());

        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add([
            'start_date_time' => '2020-04-06 08:00:00',
            'end_date_time' => '2020-04-12 09:00:00',
            'days' => '{"1":true,"2":false,"3":true,"4":false,"5":false,"6":false,"7":false}',
            'lesson' => null,
            'lesson_trashed' => 'false',
            'location' => '5',
            'location_trashed' => 'false',
            'instructor' => '1',
            'instructor_trashed' => 'false',
            'viaResource' => null,
            'viaResourceId' => null,
            'viaRelationship' => null,
            'editing' => 'true',
            'editMode' => 'create',
        ]);

        \App\Nova\PrivatePoolSession::customStoreController($request, new \App\PrivatePoolSession());

        $this->assertCount(2, PrivatePoolSession::all());
    }

    /** @test */
    public function it_should_create_a_weeks_worth_of_lessons()
    {
        $this->seed();

        $this->assertCount(0, PrivatePoolSession::all());

        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add([
            'start_date_time' => '2020-04-21 08:00:00',
            'end_date_time' => '2020-04-27 09:00:00',
            'days' => '{"1":true,"2":true,"3":true,"4":true,"5":true,"6":true,"7":true}',
            'lesson' => null,
            'lesson_trashed' => 'false',
            'location' => '5',
            'location_trashed' => 'false',
            'instructor' => '1',
            'instructor_trashed' => 'false',
            'viaResource' => null,
            'viaResourceId' => null,
            'viaRelationship' => null,
            'editing' => 'true',
            'editMode' => 'create',
        ]);

        \App\Nova\PrivatePoolSession::customStoreController($request, new \App\PrivatePoolSession());

        $this->assertCount(7, PrivatePoolSession::all());
    }
}

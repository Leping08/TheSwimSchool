<?php

namespace Tests\Feature;

use App\PoolSessionAttendance;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PoolSessionAttendanceEndpointTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    #[Test]
    public function it_will_update_the_pool_session_attendance_when_the_attended_field_is_provided()
    {
        // This is not giving the id due to it being a pivot table
        PoolSessionAttendance::factory()->create();

        // This does have an id
        $poolSessionAttendance = PoolSessionAttendance::first();

        $this->assertDatabaseHas('pool_session_attendance', [
            'attended' => false,
        ]);

        $this->postJson(route('api.pool-session-attendance.update', [$poolSessionAttendance]), [
            'attended' => true,
        ])->assertStatus(200);

        $this->assertDatabaseHas('pool_session_attendance', [
            'attended' => true,
        ]);

        $poolSessionAttendance->refresh();

        // Assert the pool session attendance has been updated
        $this->assertTrue($poolSessionAttendance->attended);
    }

    #[Test]
    public function it_will_throw_an_error_if_the_attended_field_is_not_provided()
    {
        // This is not giving the id due to it being a pivot table
        PoolSessionAttendance::factory()->create();

        // This does have an id
        $poolSessionAttendance = PoolSessionAttendance::first();

        $this->postJson(route('api.pool-session-attendance.update', [$poolSessionAttendance]), [])->assertStatus(422);

        $poolSessionAttendance->refresh();

        // Assert the pool session attendance has not been updated
        $this->assertFalse($poolSessionAttendance->attended);
    }
}

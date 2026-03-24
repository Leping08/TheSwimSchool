<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SwimTeamMeetScheduleUploadTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_guest_cannot_upload_developmental_meet_schedule_pdf()
    {
        $response = $this->post('/swim-team/meet-schedule/upload', []);
        $response->assertRedirect('/login');
    }

    #[Test]
    public function test_guest_cannot_upload_usa_competitive_meet_schedule_pdf()
    {
        $response = $this->post('/swim-team/usa-meet-schedule/upload', []);
        $response->assertRedirect('/login');
    }

    #[Test]
    public function test_authenticated_user_can_upload_developmental_meet_schedule_pdf()
    {
        Storage::fake('s3');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('PBS_Swim_Meet_Schedule.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post('/swim-team/meet-schedule/upload', [
            'meet_schedule_pdf' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue(Storage::disk('s3')->exists('pdf/PBS_Swim_Meet_Schedule.pdf'));
    }

    #[Test]
    public function test_authenticated_user_can_upload_usa_competitive_meet_schedule_pdf()
    {
        Storage::fake('s3');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('PBS_USA_Competitive_Swim_Meet_Schedule.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post('/swim-team/usa-meet-schedule/upload', [
            'usa_meet_schedule_pdf' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue(Storage::disk('s3')->exists('pdf/PBS_USA_Competitive_Swim_Meet_Schedule.pdf'));
    }
}
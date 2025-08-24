<?php

namespace Tests\Unit;

use App\Http\Controllers\SwimTeam\MeetScheduleController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MeetScheduleControllerTest extends TestCase
{
    public function test_upload_valid_pdf_saves_to_s3_and_redirects()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->create('schedule.pdf', 100, 'application/pdf');
        $request = Request::create('/swim-team/meet-schedule/upload', 'POST', [], [], [
            'meet_schedule_pdf' => $file,
        ]);

        $controller = new MeetScheduleController;
        $response = $controller->upload($request);

        $this->assertTrue(Storage::disk('s3')->exists('pdf/PBS_Swim_Meet_Schedule.pdf'));
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('Meet schedule PDF updated successfully!', $response->getSession()->get('success'));
    }

    public function test_upload_invalid_file_type_fails_validation()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->create('schedule.txt', 100, 'text/plain');
        $request = Request::create('/swim-team/meet-schedule/upload', 'POST', [], [], [
            'meet_schedule_pdf' => $file,
        ]);

        $controller = new MeetScheduleController;
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $controller->upload($request);
    }

    public function test_upload_missing_file_fails_validation()
    {
        $request = Request::create('/swim-team/meet-schedule/upload', 'POST');
        $controller = new MeetScheduleController;
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $controller->upload($request);
    }
}

<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeetScheduleController extends Controller
{
    /**
     * Handle the upload of the meet schedule PDF.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'meet_schedule_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('meet_schedule_pdf');
        $filename = 'PBS_Swim_Meet_Schedule.pdf';
        Storage::disk('s3')->putFileAs('pdf', $file, $filename, ['visibility' => 'public']);

        return redirect()->back()->with('success', 'Meet schedule PDF updated successfully!')->withFragment('swim-meet-schedules');
    }
}

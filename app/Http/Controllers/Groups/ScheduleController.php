<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    /**
     * Handle the upload of the group lesson schedule PDF.
     */
    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'group_schedule_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('group_schedule_pdf');
        $filename = 'Group_Lesson_Schedule.pdf';
        Storage::disk('s3')->putFileAs('pdf', $file, $filename, ['visibility' => 'public']);

        return redirect()->back()->with('success', 'Group lesson schedule PDF updated successfully!');
    }
}

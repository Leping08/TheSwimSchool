<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecordsController extends Controller
{
    /**
     * Handle the upload of the short course team records PDF.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'records_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $file = $request->file('records_pdf');
        $filename = 'PBS_Team_Records.pdf';
        Storage::disk('s3')->putFileAs('pdf', $file, $filename, ['visibility' => 'public']);

        return redirect()->back()->with('success', 'Short course records PDF updated successfully!')->withFragment('record_holders');
    }

    /**
     * Handle the upload of the long course team records PDF.
     */
    public function uploadLongCourse(Request $request)
    {
        $request->validate([
            'long_course_records_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $file = $request->file('long_course_records_pdf');
        $filename = 'PBS_Team_Records_Long_Course.pdf';
        Storage::disk('s3')->putFileAs('pdf', $file, $filename, ['visibility' => 'public']);

        return redirect()->back()->with('success', 'Long course records PDF updated successfully!')->withFragment('record_holders');
    }
}

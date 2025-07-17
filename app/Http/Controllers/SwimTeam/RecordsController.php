<?php

namespace App\Http\Controllers\SwimTeam;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'records_pdf' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $file = $request->file('records_pdf');
        $filename = 'PBS_Team_Records.pdf';
        Storage::disk('s3')->putFileAs('pdf', $file, $filename, ['visibility' => 'public']);

		return redirect()->back()->with('success', 'Records PDF updated successfully!')->withFragment('record_holders');
    }
}

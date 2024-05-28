<?php

namespace App\Http\Controllers;

use App\PoolSessionAttendance;
use Illuminate\Http\Request;

class PoolSessionAttendanceController extends Controller
{
    public function update($poolSessionAttendanceId)
    {
        // Validate the request has attended
        $validated = request()->validate([
            'attended' => 'required|boolean'
        ]);

        // Find the pool session attendance
        $poolSessionAttendance = PoolSessionAttendance::findOrFail($poolSessionAttendanceId);

        // Update the attendance for the pool session
        $poolSessionAttendance->update([
            'attended' => $validated['attended']
        ]);

        return response()->json($poolSessionAttendance);
    }
}

<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Swimmer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class CertificateController extends Controller
{
    public function show($encrypted_swimmer_id)
    {
        // Check if the $encrypted_swimmer_id is a valid encrypted string
        try {
            Crypt::decryptString($encrypted_swimmer_id);
        } catch (\Exception $e) {
            return Response::make('Invalid encrypted swimmer', 400);
        }

        $swimmer = Swimmer::findByEncryptedId($encrypted_swimmer_id);

        if (!$swimmer) {
            return Response::make('Swimmer not found', 404);
        }

        $swimmer->load(['lesson.group', 'lesson.instructor']);

        return view('groups.certificate', with([
            'swimmer_name' => $swimmer->firstName . ' ' . $swimmer->lastName,
            'instructor_name' => $swimmer->lesson->instructor->name,
            'lesson_completed_date' => $swimmer->lesson->class_end_date->format('m/d/y'),
            'level_icon' => $swimmer->lesson->group->icon_path,
            // Remove anything in the group type after the '(' character
            // This makes the icons fix in the certificate much better
            'level_name' => explode('(', $swimmer->lesson->group->type)[0],
        ]));
    }
}

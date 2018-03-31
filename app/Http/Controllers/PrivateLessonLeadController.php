<?php

namespace App\Http\Controllers;

use App\Location;
use App\PrivateLessonLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PrivateLessonLeadController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $lead = PrivateLessonLead::findOrFail($id);
        return view('private-lesson-leads.show', compact('lead'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $leadRequest = $request->validate([
            'swimmer_name' => 'required|string',
            'swimmer_birth_date' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'type' => 'required|string',
            'length' => 'required|string',
            'location' => 'required|string',
            'availability' => 'required|string'
        ]);

        $leadRequest['swimmer_birth_date'] = Carbon::parse($leadRequest['swimmer_birth_date']);

        //TODO: Send lead received email to admin

        $lead = PrivateLessonLead::create($leadRequest);
        Log::info("$lead->swimmer_name sent a private lesson lead. PrivateLessonLead ID: $lead->id");
        session()->flash('success', 'We will be in contact with you shortly!');
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Location;
use App\PrivateLessonLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'type' => 'required|string',
            'length' => 'required|string',
            'location' => 'required|string',
            'availability' => 'required|string'
        ]);

        //TODO: Send lead received email to admin

        $lead = PrivateLessonLead::create($request->all());
        Log::info("$lead->name sent a private lesson lead. PrivateLessonLead ID: $lead->id");
        session()->flash('success', 'We will be in contact with you shortly!');
        return back();
    }
}

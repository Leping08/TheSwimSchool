<?php

namespace App\Http\Controllers;

use App\Location;
use Carbon\Carbon;
use App\PrivateLessonLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\PrivateLessonLeadEmail;
use Illuminate\Support\Facades\Mail;

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

        //TODO: Send email to swimmers the day before tryouts start

        $lead = PrivateLessonLead::create($leadRequest);

        $this->sendLeadEmailsToAdmins($lead);
        Log::info("$lead->swimmer_name sent a private lesson lead. PrivateLessonLeadEmail ID: $lead->id");
        session()->flash('success', 'We will be in contact with you shortly!');
        return back();
    }


    /**
     * @param PrivateLessonLead $privateLessonLead
     */
    private function sendLeadEmailsToAdmins(PrivateLessonLead $privateLessonLead)
    {
        $adminEmails = config('mail.leadDestEmails');
        try {
            foreach($adminEmails as $email){
                Log::info("Sending private lesson request email to $email. Private Lesson Request ID: $privateLessonLead->id");
                Mail::to($email)->send(new PrivateLessonLeadEmail($privateLessonLead));
            }
        } catch (\Exception $e) {
            Log::error("Private Lesson Request Email Error: ".$e);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Jobs\ContactEmail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function show($id)
    {
        $lead = Contact::find($id);
        return view('leads.show', compact('lead'));
    }

    public function contactUs(Request $request)
    {
        $validData = validateRequest($request);
        $validData['contact_type_id'] = 1;
        $contact = Contact::create($validData);
        sendEmails($validData);
        Log::info("$request->name filled out the contact us contact form. Contact ID: $contact->id");
        $request->session()->flash('success', 'We will be in contact with you shortly.');
        return back();
    }

    public function lifeguarding(Request $request)
    {
        $validData = validateRequest($request);
        $validData['contact_type_id'] = 2;
        $contact = Contact::create($validData);
        sendEmails($validData);
        Log::info("$request->name filled out the lifeguarding contact form. Contact ID: $contact->id");
        $request->session()->flash('success', 'We will be in contact with you shortly.');
        return back();
    }

    public function cprFirstAid(Request $request)
    {
        $validData = validateRequest($request);
        $validData['contact_type_id'] = 3;
        $contact = Contact::create($validData);
        sendEmails($validData);
        Log::info("$request->name filled out the CPR First Aid contact form. Contact ID: $contact->id");
        $request->session()->flash('success', 'We will be in contact with you shortly.');
        return back();
    }

    public function privateLessons(Request $request)
    {
        $validData = validateRequest($request);
        $validData['contact_type_id'] = 4;
        $contact = Contact::create($validData);
        sendEmails($validData);
        Log::info("$request->name filled out the Private Swim Lessons contact form. Contact ID: $contact->id");
        $request->session()->flash('success', 'We will be in contact with you shortly.');
        return back();
    }
}

function sendEmails($validData)
{
    $leadDestEmails = config('mail.leadDestEmails');
    $subject = ContactType::find($validData['contact_type_id']);
    try {
        foreach($leadDestEmails as $email){
            ContactEmail::dispatch($validData, $subject->name, $email);
        }
    } catch (\Exception $e) {
        Log::error("Contact Email Error: ".$e);
    }
}

function validateRequest($request)
{
    return $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required'
    ]);
}

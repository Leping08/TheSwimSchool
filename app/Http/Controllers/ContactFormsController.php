<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Jobs\ContactEmail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContactFormsController extends Controller
{
    public function contactUs(Request $request)
    {
        $validData = getVaildData($request);
        $validData['contact_type_id'] = 1;
        Contact::create($validData);
        sendEmails($validData);
        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }


    public function lifeguarding(Request $request)
    {
        $validData = getVaildData($request);
        $validData['contact_type_id'] = 2;
        Contact::create($validData);
        sendEmails($validData);
        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }

    //cprFirstAid form
    public function cprFirstAid(Request $request)
    {
        $validData = getVaildData($request);
        $validData['contact_type_id'] = 3;
        Contact::create($validData);
        sendEmails($validData);
        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }

    public function privateLessons(Request $request)
    {
        $validData = getVaildData($request);
        $validData['contact_type_id'] = 4;
        Contact::create($validData);
        sendEmails($validData);
        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }
}

function sendEmails($validData)
{
    $leadDestEmails = config('mail.leadDestEmails');
    $subject = ContactType::find($validData['contact_type_id']);
    foreach($leadDestEmails as $email){
        ContactEmail::dispatch($validData, $subject->name, $email);
    }
}

function getVaildData($request)
{
    return $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required'
    ]);
}

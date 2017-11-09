<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Jobs\SendEmails;
use Carbon\Carbon;

class ContactFormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    //Contact us form
    public function contactUs(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        //Assign this contact us contact type
        $validData['contact_type_id'] = 1;

        //Contact::create($validData);
        $leadDestEmails = config('mail.leadDestEmails');

        foreach($leadDestEmails as $email){
            SendEmails::dispatch($validData, "Contact Us", $email)->delay(Carbon::now()->addMinutes(10));;
        }
        //TODO: Dispatch email job

        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }

    //Lifeguarding form
    public function lifeguarding(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        //Assign lifeguarding contact type
        $validData['contact_type_id'] = 2;

        Contact::create($validData);

        //TODO: Dispatch email job

        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }

    //cprFirstAid form
    public function cprFirstAid(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        //Assign cprFirstAid contact type
        $validData['contact_type_id'] = 3;

        Contact::create($validData);

        //TODO: Dispatch email job

        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return back();
    }

}

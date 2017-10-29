<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use App\Swimmer;
use App\Lesson;
use Log;
use Validator;
use Carbon\Carbon;
use App\Jobs\SendEmails;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Mail::to('dereks008@gmail.com')->send(new ContactUs);
        //return 'all done';
    }


    //Contact us form
    public function contactUs(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        $time = Carbon::now('America/New_York');

        $data = [
           'name' => $request->input('name'),
           'email' => $request->input('email'),
           'phone' => $request->input('phone'),
           'message' => $request->input('message'),
           'time' => $time->toDayDateTimeString(),
        ];

        $job = (new SendEmails($data))->onQueue('emails');

        dispatch($job);

        // $leadDestEmails = config('mail.leadDestEmails');
        // foreach($leadDestEmails as $emailAddress){
        //     Mail::to($emailAddress)->send(new ContactUs($data));
        //     Log::info('Email sent to: '.$emailAddress.' at '.$time->toDayDateTimeString());
        // }

        $request->session()->flash('success', 'Message Sent! We will be in contact with you shortly.');
        return redirect('/contact-us');
    }      

}

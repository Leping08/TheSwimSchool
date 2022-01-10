<?php

namespace App\Http\Controllers;

use App\Mail\NewsLetter\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomNewsletter extends Controller
{
    public function sendOne(Request $request)
    {
        $request->validate([
            'email_address' => 'required|email',
            'email_subject' => 'required',
            'body' => 'required',
            'image_url' => 'required',
            'button_url' => 'required',
            'button_text' => 'required',
            'to_email' => 'required|email',
        ]);
        
        $template = new Custom(
            $request->get('email_address'), 
            $request->get('email_subject'), 
            $request->get('body'), 
            $request->get('image_url'), 
            $request->get('button_url'), 
            $request->get('button_text')
        );
        
        Mail::to($request->to_email)->send($template);
    }

    public function sendToAll(Request $request)
    {
        $request->validate([
            'email_address' => 'required|email',
            'email_subject' => 'required',
            'body' => 'required',
            'image_url' => 'required',
            'button_url' => 'required',
            'button_text' => 'required',
            'to_email' => 'required|email',
        ]);
        
        $template = new Custom(
            $request->get('email_address'), 
            $request->get('email_subject'), 
            $request->get('body'), 
            $request->get('image_url'), 
            $request->get('button_url'), 
            $request->get('button_text')
        );

        //TODO: Run through all bad emails and unsubscribe them
        //TODO: Send to all users
    }
}

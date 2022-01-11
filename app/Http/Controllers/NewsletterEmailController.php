<?php

namespace App\Http\Controllers;

use App\PageParameters;
use Illuminate\Http\Request;

class NewsletterEmailController extends Controller
{
    public function index()
    {
        return view('email.newsletter.edit');
    }

    public function show()
    {
        return PageParameters::getNewsLetterEmail();
    }

    public function store(Request $request)
    {
        $newsletter = PageParameters::getNewsLetterEmail();

        $request->validate([
            'subject' => ['string', 'required'],
            'image_url' => ['string', 'required', 'url'],
            'button_url' => ['string', 'required'],
            'button_text' => ['string', 'required'],
            'body_text' => ['string', 'required'],
            'preview_email_address' => ['string', 'required']
        ]);

        $newsletter->configuration = [
            'subject' => $request->get('subject'),
            'image_url' => $request->get('image_url'),
            'button_url' => $request->get('button_url'),
            'button_text' => $request->get('button_text'),
            'body_text' => $request->get('body_text'),
            'preview_email_address' => $request->get('preview_email_address')
        ];

        $newsletter->save();
        return $newsletter->refresh();
    }

    public function preview(Request $request)
    {
        return new \App\Mail\NewsLetter\Custom(
            'testing@gmail.com', 
            $request->get('subject'),
            $request->get('body_text'),
            $request->get('image_url'),
            $request->get('button_url'),
            $request->get('button_text'),
        );
    }
}

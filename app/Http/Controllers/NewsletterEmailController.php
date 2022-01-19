<?php

namespace App\Http\Controllers;

use App\EmailList;
use App\Jobs\NewsLetter\SendCustomNewsLetterEmail;
use App\Library\Mailgun\Mailgun;
use App\PageParameters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        return new \App\Mail\NewsLetter\CustomNewsLetter(
            $request->get('preview_email_address'),
            $request->get('subject'),
            $request->get('body_text'),
            $request->get('image_url'),
            $request->get('button_url'),
            $request->get('button_text'),
        );
    }

    public function sendPreview(Request $request)
    {
        $request->validate([
            'preview_email_address' => ['string', 'required', 'email']
        ]);

        $newsLetter = PageParameters::getNewsLetterEmail();

        $email = new \App\Mail\NewsLetter\CustomNewsLetter(
            $request->get('preview_email_address'),
            $newsLetter->configuration['subject'],
            $newsLetter->configuration['body_text'],
            $newsLetter->configuration['image_url'],
            $newsLetter->configuration['button_url'],
            $newsLetter->configuration['button_text'],
        );

        try {
            Mail::to($request->get('preview_email_address'))->send($email);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendEmails()
    {
        Mailgun::removeComplaintsEmails();

        $pageParameters = PageParameters::getNewsLetterEmail();

        if (!$pageParameters) {
            throw new \Exception('No email newsletter in the database');
        }

        $emailList = EmailList::where('subscribe', '=', true)
            ->pluck('email')
            ->map(function ($email) use ($pageParameters) {
                SendCustomNewsLetterEmail::dispatch($email, $pageParameters);
            });

        return collect([
            'message' => "{$emailList->count()} emails sent successfully!"
        ]);
    }

    public function uploadImage(Request $request)
    {
        // save image to news letter folder
        $imageHash = str_replace('tmp/', '', $request->input('key'));
        Storage::disk('s3')->copy(
            $request->input('key'),
            'news-letter/' . $imageHash
        );

        $imageUrl = Storage::disk('s3')->url('news-letter/' . $imageHash);

        $newsLetter = PageParameters::getNewsLetterEmail();
        $tempNewsLetterConfig = collect($newsLetter->configuration);
        $tempNewsLetterConfig['image_url'] = $imageUrl;
        $newsLetter->configuration = $tempNewsLetterConfig->toArray();
        $newsLetter->save();
        return $newsLetter->refresh();
    }
}

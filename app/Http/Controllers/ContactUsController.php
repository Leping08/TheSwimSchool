<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mail\Admin\ContactUs;
use App\Rules\Recaptcha;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // @todo clean up store lead request

        // Check if all honeypot fields are empty
        $emptyHoneypot = collect([
            $request->first_name,
            $request->last_name,
            $request->address,
            $request->city,
            $request->state,
            $request->zip,
            $request->country,
        ])->filter()->isEmpty();

        if (!$emptyHoneypot) {
            Log::info('Honeypot fields were not empty.');
            session()->flash('warning', 'Are you a robot?');
            return back();
        }

        // Get the timestamp field and check if it is not within the last 3 seconds
        if ((int)$request->time > (Carbon::now()->timestamp - 3)) {
            Log::info('Timestamp was not within the last 3 seconds.');
            session()->flash('warning', 'Are you a robot?');
            return back();
        }

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => App::runningUnitTests() ? [] : ['required', new Recaptcha()],
        ]);

        try {
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'],
                'contact_type_id' => 1, // Contact Type: Contact Us
            ]);
            $this->emailAdmins($contact);
            session()->flash('success', 'Thank you for reaching out. We will be in contact with you shortly.');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e->getTraceAsString());
            session()->flash('warning', 'Looks like something went wrong.');
        }

        return back();
    }

    /**
     * @param  Contact  $contact
     */
    // @todo move this over to the Contact model
    private function emailAdmins(Contact $contact)
    {
        foreach (config('mail.lead_dest_emails') as $email) {
            Log::info("Sending contact us email to: $email.");
            Mail::to($email)->send(new ContactUs($contact, $contact->type->name));
            Log::info($contact->type->name." Email sent to: $email.");
        }
    }
}

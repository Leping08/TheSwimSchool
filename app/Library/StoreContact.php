<?php


namespace App\Library;


use App\Contact;
use App\Mail\ContactUs;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class StoreContact
{
    /**
     * StoreContact constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->validateRequest($request);
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function validateRequest(Request $request) : bool
    {
        $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'required',
                'g-recaptcha-response' => ['required', new Recaptcha()],
            ],
            [
                'g-recaptcha-response.required' => "Check the I'm not a robot box"
            ]
        );

        $request = $this->assignRequestContactId($request);

        $contact = Contact::create($request->all());

        $this->emailAdmin($contact);

        return true;
    }


    /**
     * @param Request $request
     * @return Request
     */
    public function assignRequestContactId(Request $request) : Request
    {
        if($request->path() === 'contact-us'){
            $request['contact_type_id'] = 1;
        }

        if($request->path() === 'lifeguarding'){
            $request['contact_type_id'] = 2;
        }

        if($request->path() === 'cpr-first-aid'){
            $request['contact_type_id'] = 3;
        }

        if($request->path() === 'private-semi-private'){
            $request['contact_type_id'] = 4;
        }
        return $request;
    }


    /**
     * @param Contact $contact
     */
    private function emailAdmin(Contact $contact)
    {
        foreach(config('mail.leadDestEmails') as $email){
            Mail::to($email)->send(new ContactUs($contact, $contact->type->name));
            Log::info("$contact->type->name Email sent to: $email.");
        }
    }
}
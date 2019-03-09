<?php

namespace App\Http\Requests;

use App\Models\Contact;
use App\Mail\ContactUs;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StoreLead extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required' => "Check the I'm not a robot box"
        ];
    }

    /**
     *
     */
    public function save()
    {
        $validated = $this->validated();

        try {
            $contact = Contact::create($this->assignRequestContactId($validated));
            $this->emailAdmin($contact);
            session()->flash('success', 'We will be in contact with you shortly.');
        } catch (\Exception $e) {
            report($e);
            session()->flash('warning', 'Looks like something went wrong.');
        }
    }


    /**
     * @param array $validated
     * @return array
     */
    private function assignRequestContactId(array $validated)
    {
        //TODO: Add these values to the DB
        $leadTypeIds = [
            'contact-us' => 1,
            'lifeguarding' => 2,
            'cpr-first-aid' => 3,
            'private-semi-private' => 4
        ];

        foreach ($leadTypeIds as $key => $value) {
            if (request()->path() === $key) {
                $validated['contact_type_id'] = $value;
            }
        }

        return $validated;
    }

    /**
     * @param Contact $contact
     */
    private function emailAdmin(Contact $contact)
    {
        foreach (config('mail.leadDestEmails') as $email) {
            Mail::to($email)->send(new ContactUs($contact, $contact->type->name));
            Log::info($contact->type->name . " Email sent to: $email.");
        }
    }
}

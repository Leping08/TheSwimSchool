<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactType;
use Illuminate\Http\Request;
use App\Jobs\ContactEmail;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function show($id)
    {
        $lead = Contact::find($id);
        return view('leads.show', compact('lead'));
    }

    public function contact(Request $request)
    {
        $validData = $this->validateRequest($request);
        $newContact = $this->createContact($this->assignRequestContactId($request, $validData));
        $this->sendEmails($newContact);
        $request->session()->flash('success', 'We will be in contact with you shortly.');
        return back();
    }

    private function validateRequest($request): array
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);
    }

    private function assignRequestContactId(Request $request, $validData): array
    {
        if($request->path() === 'contact-us'){
            $validData['contact_type_id'] = 1;
        }

        if($request->path() === 'lifeguarding'){
            $validData['contact_type_id'] = 2;
        }

        if($request->path() === 'cpr-first-aid'){
            $validData['contact_type_id'] = 3;
        }

        if($request->path() === 'private-semi-private'){
            $validData['contact_type_id'] = 4;
        }
        return $validData;
    }

    private function createContact($newContact): Contact
    {
        return Contact::create($newContact);
    }

    private function sendEmails($newContact)
    {
        $adminEmails = config('mail.leadDestEmails');
        $subject = ContactType::find($newContact['contact_type_id']);
        try {
            foreach($adminEmails as $email){
                ContactEmail::dispatch($newContact, $subject->name, $email);
            }
        } catch (\Exception $e) {
            Log::error("Contact Email Error: ".$e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Library\StoreContact;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * @param $lead
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Contact $lead)
    {
        return view('leads.show', compact('lead'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        (new StoreContact($request))
            ? session()->flash('success', 'We will be in contact with you shortly.')
            : session()->flash('warning', 'Something went wrong.');
        return back();
    }
}

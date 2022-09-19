<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\StoreLead;

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
     * @param  StoreLead  $lead
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLead $lead)
    {
        $lead->save();

        return back();
    }
}

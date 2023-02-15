<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLead;

class ContactUsController extends Controller
{
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

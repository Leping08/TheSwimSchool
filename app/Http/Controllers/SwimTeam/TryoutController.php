<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use App\Tryout;
use Illuminate\View\View;

class TryoutController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $tryouts = Tryout::registrationOpen()->with('location')->get();
        return view('tryouts.index', compact('tryouts'));
    }

    /**
     * @param Tryout $tryout
     * @return View
     */
    public function show(Tryout $tryout)
    {
        $tryout->load('location', 'athletes');
        return view('tryouts.signup', compact('tryout'));
    }
}

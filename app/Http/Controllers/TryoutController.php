<?php

namespace App\Http\Controllers;

use App\Tryout;
use App\Location;
use App\STSeason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Library\Helpers\SeasonHelpers;

class TryoutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tryouts = Tryout::registrationOpen()->with('location')->get();

        return view('tryouts.index', compact('tryouts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signUp($id)
    {
        $tryout = Tryout::with('location', 'athletes')->find($id);

        return view('tryouts.signup', compact('tryout'));
    }
}

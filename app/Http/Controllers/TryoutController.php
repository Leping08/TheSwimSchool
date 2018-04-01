<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Tryout;

class TryoutController extends Controller
{
    public function index()
    {
        $tryouts = Tryout::with('location', 'athletes')->where('registration_open', '<=', Carbon::now())->get();
        return view('tryouts.index', compact('tryouts'));
    }

    public function show($id)
    {
        $tryout = Tryout::find($id)->with('location', 'athletes')->get();
        return view('tryouts.index', compact('tryout'));
    }
}

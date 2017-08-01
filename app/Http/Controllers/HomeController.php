<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swimmer;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $swimmers = Swimmer::orderBy('created_at', 'desc')->limit(10)->get();
        return view('pages.dashboard', compact('swimmers'));
    }

}

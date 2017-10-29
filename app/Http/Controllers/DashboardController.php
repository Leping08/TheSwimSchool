<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swimmer;

class DashboardController extends Controller
{
    public function index()
    {
        $swimmers = Swimmer::orderBy('created_at', 'desc')->limit(10)->get();
        return view('pages.dashboard', compact('swimmers'));
    }
}

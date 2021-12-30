<?php

namespace App\Http\Controllers;

use App\Instructor;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $instructors = Instructor::where('active', true)->get();
        return view('pages.about', compact('instructors'));
    }
}

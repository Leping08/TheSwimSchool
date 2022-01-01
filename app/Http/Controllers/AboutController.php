<?php

namespace App\Http\Controllers;

use App\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        $instructors = Cache::remember('about_instructors', config('cache.time'), function () {
            return Instructor::where('active', true)->get();
        });
        return view('pages.about', compact('instructors'));
    }
}

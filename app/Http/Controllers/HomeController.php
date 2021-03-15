<?php

namespace App\Http\Controllers;

use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = Cache::remember('reviews', Carbon::now()->addDay(), function () {
            return Review::active()->orderBy('created_time', 'desc')->limit(10)->get();
        });
        return view('pages.home', compact('reviews'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::active()->limit(10)->get();

        return view('pages.home', compact('reviews'));
    }
}

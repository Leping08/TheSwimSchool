<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('pages.home', compact('reviews'));
    }
}

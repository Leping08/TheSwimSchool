<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $reviews = Review::active()->limit(10)->get();
        return view('pages.home', compact('reviews'));
    }
}

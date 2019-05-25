<?php

namespace App\Http\Controllers;

use App\FeedbackQuestion;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $questions = FeedbackQuestion::with('type', 'category')->get();
        return view('feedback.index', compact('questions'));
    }
}

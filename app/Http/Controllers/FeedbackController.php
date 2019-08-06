<?php

namespace App\Http\Controllers;

use App\Models\FeedbackAnswer;
use App\Models\FeedbackSurvey;
use App\Models\FeedbackQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index()
    {
        $questions = FeedbackQuestion::with('type', 'category')->get();

        return view('feedback.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_1' => 'required|numeric',
            'question_2' => 'required|numeric',
            'question_3' => 'required|numeric',
            'question_4' => 'required|numeric',
            'question_5' => 'required|numeric',
            'question_6' => 'required|numeric',
            'question_7' => 'required|numeric',
            'question_8' => 'required|numeric',
            'question_9' => 'required|numeric',
            'question_10' => 'required|numeric',
            'question_11' => 'required|numeric',
            'question_12' => 'required|numeric',
            'question_13' => 'required|numeric',
            'question_14' => 'required|numeric',
            'question_15' => 'nullable',
            'question_16' => 'nullable',
            'question_17' => 'nullable',
            'question_18' => 'nullable',
        ]);

        Log::info('Creating a feedback survey');

        $survey = FeedbackSurvey::create([
            'viewed' => false,
        ]);

        foreach ($request->except('_token') as $key => $answer) {
            FeedbackAnswer::create([
                'answer' => $answer,
                'feedback_question_id' => trim($key, 'question_'),
                'feedback_survey_id' => $survey->id,
            ]);
        }

        Log::info('Feedback survey and answers saved');

        session()->flash('success', 'Thank you for filling out the survey. We appreciate the feedback and will use it to improve our services.');

        return redirect('/thank-you');
    }
}

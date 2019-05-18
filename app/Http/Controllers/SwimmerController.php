<?php

namespace App\Http\Controllers;


use App\EmailList;
use App\Http\Requests\LessonSignUp;
use App\Library\Lesson\Enroll;
use App\Library\StripeCharge;
use App\Mail\ClassFull;
use App\Mail\SignUp;
use App\Swimmer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SwimmerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(LessonSignUp $request)
    {
        (new Enroll())->handle();
        return redirect('/thank-you');
    }
}

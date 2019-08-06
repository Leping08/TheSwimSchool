<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Swimmer;
use App\Models\EmailList;
use Carbon\Carbon;
use App\Mail\SignUp;
use App\Mail\ClassFull;
use Illuminate\Http\Request;
use App\Library\StripeCharge;
use App\Library\Lesson\Enroll;
use App\Http\Requests\LessonSignUp;
use Illuminate\Support\Facades\Log;
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

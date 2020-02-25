<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Mail\STInvitation;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Tryout;
use App\Athlete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CalendarContolller extends Controller
{
    public function show(Lesson $lesson)
    {

    }
}

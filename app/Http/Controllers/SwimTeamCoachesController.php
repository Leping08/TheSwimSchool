<?php

namespace App\Http\Controllers;

use App\STCoach;
use Illuminate\Http\Request;

class SwimTeamCoachesController extends Controller
{
    public function index()
    {
        $coaches = STCoach::active()->get();
        return view('swim-team.swim-team', compact('coaches'));
    }
}

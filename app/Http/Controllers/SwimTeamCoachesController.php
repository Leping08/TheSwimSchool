<?php

namespace App\Http\Controllers;

use App\Banner;
use App\STCoach;
use Illuminate\Http\Request;

class SwimTeamCoachesController extends Controller
{
    public function index()
    {
        $coaches = STCoach::active()->get();
        $banner = Banner::where('page', '/swim-team')->first();
        return view('swim-team.swim-team', compact('coaches', 'banner'));
    }
}

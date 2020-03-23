<?php

namespace App\Http\Controllers\SwimTeam;

use App\Banner;
use App\Http\Controllers\Controller;
use App\STCoach;

class CoachesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $coaches = STCoach::active()->get();
        $banner = Banner::where('page', '/swim-team')->first();
        return view('swim-team.swim-team', compact('coaches', 'banner'));
    }
}

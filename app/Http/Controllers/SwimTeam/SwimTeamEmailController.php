<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use App\Mail\SwimTeam\SwimTeamCurrentSwimmerRegistration;
use App\STSwimmer;
use Illuminate\Support\Facades\Mail;

class SwimTeamEmailController extends Controller
{
	public function index()
	{
		$sTSwimmers = STSwimmer::where('season_id', '=', 7)->get();

		$sTSwimmers->each(function ($sTSwimmer) {
			Mail::to($sTSwimmer->email)->queue(new SwimTeamCurrentSwimmerRegistration($sTSwimmer));
		});

		return route('swim-team.thank-you');
	}
}

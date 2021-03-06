<?php

namespace App\Http\Controllers\SwimTeam;

use App\Athlete;
use App\Http\Controllers\Controller;
use App\Http\Requests\SwimTeamSignUp;
use App\Library\Helpers\Promo;
use App\Library\StripeCharge;
use App\Mail\SwimTeam\STSignUp;
use App\STLevel;
use App\STSeason;
use App\STShirtSize;
use App\STSwimmer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SwimmerController extends Controller
{
    use Promo;

    /**
     * @param  STLevel  $level
     * @param  null  $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(STLevel $level, $hash = null)
    {
        $athlete = Athlete::findByHash($hash)->first() ?? null;
        $season = STSeason::currentSeason();
        $sizes = STShirtSize::all();
        return view('swim-team.signUp', compact('level', 'season', 'athlete', 'sizes'));
    }

    /**
     * @param  SwimTeamSignUp  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SwimTeamSignUp $request)
    {
        $level = STLevel::find(request()->level_id);
        $size = STShirtSize::find(request()->shirt_size_id);
        $promo = $this->validatePromoCode();

        $swimTeamSwimmer = request()->merge([
            'birthDate' => Carbon::parse(request()->birthDate),
            's_t_level_id' => $level->id,
            's_t_season_id' => STSeason::currentSeason()->id,
            'promo_code_id' => $promo->id ?? null,
            's_t_shirt_size_id' => $size->id ?? null
        ]);

        $price = $promo ? $promo->apply($level->price) : $level->price;

        //Check if the stripe charge is even needed   Ex: 100% off promo code
        if ($price <= 0) {
            Log::info("Swim Team Swimmer $swimTeamSwimmer->firstName $swimTeamSwimmer->lastName, Email: $swimTeamSwimmer->email has signed up with out paying. They used promo code ID: $swimTeamSwimmer->promo_code_id");
            $swimTeamSwimmer = request()->merge([
                'stripeChargeId' => 'For Free Promo Code'
            ]);
        } else {
            try {
                $stripeChargeId = (new StripeCharge(
                    request()->stripeToken,
                    $price,
                    request()->email,
                    config('swim-team.full-name')." ".$level->name." Level for ".request()->firstName." ".request()->lastName."."
                ))->charge()->id;
            } catch (\Exception $exception) {
                return back();
            }

            $swimTeamSwimmer = request()->merge([
                'stripeChargeId' => $stripeChargeId
            ]);
        }

        //Create the swim team swimmer
        $swimNewTeamSwimmer = STSwimmer::create($swimTeamSwimmer->toArray());

        try {
            Log::info("Sending swim team sign up email to $swimNewTeamSwimmer->email for STSwimmer ID: $swimNewTeamSwimmer->id.");
            Mail::to($swimNewTeamSwimmer->email)->send(new STSignUp($swimNewTeamSwimmer));
        } catch (\Exception $e) {
            Log::error("Swim Team sign up Email Error: ".$e);
        }

        Log::info("$swimNewTeamSwimmer->firstName $swimNewTeamSwimmer->lastName, ID: $swimNewTeamSwimmer->id has signed up for Level ID: $swimNewTeamSwimmer->s_t_level_id with the ".config('swim-team.full-name').'.');
        session()->flash('success', 'Thanks for signing up for the '.config('swim-team.full-name').'!');
        return redirect('/thank-you');
    }
}

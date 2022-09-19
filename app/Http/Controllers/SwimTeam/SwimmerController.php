<?php

namespace App\Http\Controllers\SwimTeam;

use App\Athlete;
use App\Http\Controllers\Controller;
use App\Http\Requests\SwimTeamSignUp;
use App\Library\Helpers\Promo;
use App\Library\StripeCharge;
use App\Mail\SwimTeam\STSignUp;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STShirtSize;
use App\STSwimmer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;

class SwimmerController extends Controller
{
    use Promo;

    /**
     * @param  STLevel  $level
     * @param  null  $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(STLevel $level, $hash)
    {
        $athlete = Athlete::findByHash($hash)->first();
        if (! $athlete) {
            abort(404);
        }
        $level = $athlete->level;
        $season = STSeason::currentSeason();

        return view('swim-team.signUp', compact('level', 'season', 'athlete'));
    }

    public function register(STLevel $level, STSwimmer $swimmer)
    {
        $season = STSeason::currentSeason();

        return view('swim-team.register', compact('level', 'season', 'swimmer'));
    }

    public function savePromoCode(Request $request)
    {
        $request->validate([
            'promo_code' => 'required',
            'swimmer_id' => 'required',
        ]);

        // check if the promo code is valid
        $promoCode = PromoCode::where('code', '=', $request->get('promo_code'))->first();

        // check if the percentage off is over 100% and if so set the note in the swimmer details
        if ($promoCode->discount_percent >= 100) {
            $swimmer = STSwimmer::find($request->get('swimmer_id'));
            $swimmer->notes = json_encode([
                'promo_code' => $promoCode->code,
            ]);
            $swimmer->promo_code_id = $promoCode->id;
            $swimmer->save();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'The promo code you entered is not 100% off.',
            ]);
        }

        // todo send the confirmation email
        return [
            'success' => true,
            'redirect' => route('swim-team.thank-you'),
        ];
    }

    public function update(Request $request)
    {
        $swimmer = STSwimmer::find($request->get('swimmerId'));

        // filter down only values that have changed
        $swimmer->update($request->only([
            'firstName',
            'lastName',
            'birthDate',
            'parent',
            'email',
            'phone',
            'parent',
            'street',
            'city',
            'state',
            'zip',
            'emergencyName',
            'emergencyRelationship',
            'emergencyPhone',
        ]));
        // update the season to be the current season
        $swimmer->s_t_season_id = STSeason::currentSeason()->id;
        $swimmer->save();

        return response()->json($swimmer);
    }

    /**
     * @param  Request  $request
     * @param  STLevel  $level
     * @param  null  $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store2(Request $request, STLevel $level, STSwimmer $swimmer)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($request->query('payment_intent'));

        // update the swimmer notes with the stripe data
        $swimmer->notes = json_encode([
            'stripe_payment_intent' => $paymentIntent->id,
            'stripe_customer_id' => $paymentIntent->customer,
        ]);
        $swimmer->save();

        // send a confirmation email with the first practice date
        Log::info("Sending swim team sign up email to $swimmer->email for STSwimmer ID: $swimmer->id.");
        Mail::to($swimmer->email)->send(new STSignUp($swimmer));
        Log::info("Swim team sign up email sent to $swimmer->email for STSwimmer ID: $swimmer->id.");

        // redirect to the thank you page
        return redirect()->route('swim-team.thank-you');
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
            's_t_shirt_size_id' => $size->id ?? null,
        ]);

        $price = $promo ? $promo->apply($level->price) : $level->price;

        //Check if the stripe charge is even needed   Ex: 100% off promo code
        if ($price <= 0) {
            Log::info("Swim Team Swimmer $swimTeamSwimmer->firstName $swimTeamSwimmer->lastName, Email: $swimTeamSwimmer->email has signed up with out paying. They used promo code ID: $swimTeamSwimmer->promo_code_id");
            $swimTeamSwimmer = request()->merge([
                'stripeChargeId' => 'For Free Promo Code',
            ]);
        } else {
            try {
                $stripeChargeId = (new StripeCharge(
                    request()->stripeToken,
                    $price,
                    request()->email,
                    config('swim-team.full-name').' '.$level->name.' Level for '.request()->firstName.' '.request()->lastName.'.'
                ))->charge()->id;
            } catch (\Exception $exception) {
                return back();
            }

            $swimTeamSwimmer = request()->merge([
                'stripeChargeId' => $stripeChargeId,
            ]);
        }

        //Create the swim team swimmer
        $swimNewTeamSwimmer = STSwimmer::create($swimTeamSwimmer->toArray());

        try {
            Log::info("Sending swim team sign up email to $swimNewTeamSwimmer->email for STSwimmer ID: $swimNewTeamSwimmer->id.");
            Mail::to($swimNewTeamSwimmer->email)->send(new STSignUp($swimNewTeamSwimmer));
        } catch (\Exception $e) {
            Log::error('Swim Team sign up Email Error: '.$e);
        }

        Log::info("$swimNewTeamSwimmer->firstName $swimNewTeamSwimmer->lastName, ID: $swimNewTeamSwimmer->id has signed up for Level ID: $swimNewTeamSwimmer->s_t_level_id with the ".config('swim-team.full-name').'.');
        session()->flash('success', 'Thanks for signing up for the '.config('swim-team.full-name').'!');

        return redirect('/thank-you');
    }

    public function thankyou()
    {
        return view('swim-team.thank-you');
    }

    // todo deprecate soon
    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request)
    {
        $promo_code = $request->get('promo_code');
        $promo = PromoCode::where('code', $promo_code)->first();

        // Throw error if no promo code is found
        if (! $promo) {
            throw new Exception('Invalid promo code.', 400);
        }

        // Check if it is over 100% off
        if (! ($promo->discount_percent >= 100)) {
            throw new Exception('Not over 100% off.', 400);
        }

        $athlete = Athlete::where('hash', $request->get('hash'))->first();
        $level = STLevel::findOrFail($request->get('level_id'));

        // if no ash is found, throw an error
        if (! $athlete) {
            throw new Exception('Invalid hash.', 400);
        }

        // create a swimmer from the athlete data
        $swimmer = STSwimmer::create([
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
            'email' => $athlete->email,
            'phone' => $athlete->phone,
            'birthDate' => $athlete->birthDate,
            'parent' => $athlete->parent,
            'notes' => json_encode([
                'details' => 'Swimmer signed up with a free promo code.',
                'athlete_id' => $athlete->id,
            ]),
            'street' => $athlete->street,
            'city' => $athlete->city,
            'state' => $athlete->state,
            'zip' => $athlete->zip,
            'emergencyName' => $athlete->emergencyName,
            'emergencyRelationship' => $athlete->emergencyRelationship,
            'emergencyPhone' => $athlete->emergencyPhone,
            's_t_level_id' => $level->id,
            's_t_season_id' => STSeason::currentSeason()->id,
            'promo_code_id' => $promo->id,
        ]);

        // send a confirmation email with the first practice date
        Log::info("Sending swim team sign up email to $swimmer->email for STSwimmer ID: $swimmer->id.");
        Mail::to($swimmer->email)->send(new STSignUp($swimmer));
        Log::info("Swim team sign up email sent to $swimmer->email for STSwimmer ID: $swimmer->id.");

        // redirect to the thank you page
        return redirect()->route('swim-team.thank-you');
    }

    public function store3($hash)
    {
        $athlete = Athlete::where('hash', $hash)->first();

        if (! $athlete) {
            throw new Exception('Invalid hash.', 400);
        }

        $sTLevel = $athlete->level;

        $request = request();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($request->query('payment_intent'));

        // create a swimmer from the athlete data
        $swimmer = STSwimmer::create([
            'firstName' => $athlete->firstName,
            'lastName' => $athlete->lastName,
            'email' => $athlete->email,
            'phone' => $athlete->phone,
            'birthDate' => $athlete->birthDate,
            'parent' => $athlete->parent,
            'notes' => json_encode([
                'stripe_payment_intent' => $paymentIntent->id,
                'stripe_customer_id' => $paymentIntent->customer,
            ]),
            'street' => $athlete->street,
            'city' => $athlete->city,
            'state' => $athlete->state,
            'zip' => $athlete->zip,
            'emergencyName' => $athlete->emergencyName,
            'emergencyRelationship' => $athlete->emergencyRelationship,
            'emergencyPhone' => $athlete->emergencyPhone,
            's_t_level_id' => $sTLevel->id,
            's_t_season_id' => STSeason::currentSeason()->id,
            'promo_code' => $request->get('promo_code'),
        ]);

        // send a confirmation email with the first practice date
        Log::info("Sending swim team sign up email to $swimmer->email for STSwimmer ID: $swimmer->id.");
        Mail::to($swimmer->email)->send(new STSignUp($swimmer));
        Log::info("Swim team sign up email sent to $swimmer->email for STSwimmer ID: $swimmer->id.");

        // redirect to thank you page
        return redirect()->route('swim-team.thank-you');
    }
}

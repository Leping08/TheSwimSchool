<?php

namespace App\Http\Controllers\SwimTeam;

use App\Athlete;
use App\Http\Controllers\Controller;
use App\Mail\SwimTeam\STSignUp;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Stripe\StripeClient;

class SwimmerController extends Controller
{
    /**
     * @param  STLevel  $level
     * @param  null  $hash
     * @return Factory|View
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
     * @return Factory|View
     */
    public function store2(Request $request, STLevel $level, STSwimmer $swimmer)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $paymentIntent = $stripe->paymentIntents->retrieve($request->query('payment_intent'));

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

    public function thankyou()
    {
        return view('swim-team.thank-you');
    }

    // todo deprecate soon
    /**
     * @param  Request  $request
     * @return Factory|View
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

        $stripe = new StripeClient(config('services.stripe.secret'));
        $paymentIntent = $stripe->paymentIntents->retrieve($request->query('payment_intent'));

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

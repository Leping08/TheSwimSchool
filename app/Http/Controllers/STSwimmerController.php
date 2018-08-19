<?php

namespace App\Http\Controllers;

use App\Mail\STSignUp;
use App\PromoCode;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;

class STSwimmerController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $level = STLevel::find($id);
        return view('swim-team.signUp', compact('level'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $id)
    {
        $swimmer = $request->validate([
            'firstName' => 'required|string|max:191',
            'lastName' => 'required|string|max:191',
            'birthDate' => 'required|date|before:today',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20',
        ]);
        $swimmer['birthDate'] = Carbon::parse($swimmer['birthDate']);

        $level = STLevel::find($id);
        $swimmer['s_t_level_id'] = $level->id;

        $swimmer['s_t_season_id'] = STSeason::GetCurrentSeason()->id;

        $swimmer['promo_code_id'] = $this->validatePromoCode($request);

        $newSwimmer = STSwimmer::create($swimmer);

        Log::info("Swim Team Swimmer $newSwimmer->firstName $newSwimmer->lastName, ID: $newSwimmer->id has signed up for Level ID: $newSwimmer->s_t_level_id and is going to pay by card.");

        return redirect('/swim-team/checkout/'.$newSwimmer->id);
    }

    /**
     * @param Request $request
     * @return null
     */
    private function validatePromoCode(Request $request)
    {
        if(!empty($request->promo_code)){
            Log::info("Trying to find Promo for string: $request->promo_code");
            $userCode = trim(strtoupper($request->promo_code));
            $promo = PromoCode::where('code', $userCode)->first();

            if(count($promo)){
                Log::info("Found Promo Code ID: $promo->id");
                return $promo->id;
            }
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function checkout($id)
    {
        $swimmer = STSwimmer::find($id);
        if(! $swimmer->stripeChargeId){
            return view('swim-team.checkOut', compact('swimmer'));
        } else {
            return redirect('/swim-team');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function pay(Request $request)
    {
        $request->validate([
            'cardholderName' => 'required',
            'cardholderEmail' => 'required|email',
            'swimmerId' => 'required'
        ]);

        $swimmer = STSwimmer::with('level')->find($request->swimmerId);

        try{
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $charge = \Stripe\Charge::create(array(
                "amount" => $swimmer->promoAppliedPrice() * 100,
                "currency" => "usd",
                "receipt_email" => "$request->cardholderEmail",
                "description" => "North River Swim Team ".$swimmer->level->name." Level for ".$swimmer->firstName." ".$swimmer->lastName." through The Swim School.",
                "source" => "$request->stripeToken" //Obtained with Stripe.js
            ));
        } catch(Card $e){
            $body = $e->getJsonBody();
            $err  = $body['error'];
            Log::error($err['message']);
            $request->session()->flash('error', $err['message']);
            return view('swim-team.checkOut', compact('swimmer'));
        } catch (InvalidRequest $e){
            Log::error('Invalid parameters were supplied to Stripes API');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swim-team.checkOut', compact('swimmer'));
        } catch (Authentication $e){
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swim-team.checkOut', compact('swimmer'));
        }  catch (Base $e) {
            Log::error('Generic error occurred');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swim-team.checkOut', compact('swimmer'));
        }

        $this->updateSwimmerWithPayment($swimmer, $charge);

        $this->sendSignUpEmail($swimmer);

        $request->session()->flash('success', 'Thanks for signing up for The North River Swim Team!');

        return redirect('/swim-team');
    }


    /**
     * @param STSwimmer $swimmer
     * @param $charge
     */
    private function updateSwimmerWithPayment(STSwimmer $swimmer, $charge)
    {
        $swimmer->stripeChargeId = $charge->id;
        $swimmer->save();
        Log::info("Swim Team Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");
    }


    /**
     * @param STSwimmer $swimmer
     */
    private function sendSignUpEmail(STSwimmer $swimmer)
    {
        try {
            Log::info("Sending swim team sign up email to $swimmer->email for STSwimmer ID: $swimmer->id.");
            Mail::to($swimmer->email)->send(new STSignUp($swimmer));

        } catch (\Exception $e) {
            Log::error("Swim Team sign up Email Error: ".$e);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roster()
    {
        $levels = STLevel::with('swimmers')->get();
        return view('swim-team.roster', compact('levels'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\STSwimmer  $sTSwimmer
     * @return \Illuminate\Http\Response
     */
    public function show(STSwimmer $sTSwimmer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\STSwimmer  $sTSwimmer
     * @return \Illuminate\Http\Response
     */
    public function edit(STSwimmer $sTSwimmer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\STSwimmer  $sTSwimmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, STSwimmer $sTSwimmer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\STSwimmer  $sTSwimmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(STSwimmer $sTSwimmer)
    {
        //
    }
}

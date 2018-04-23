<?php

namespace App\Http\Controllers;

use App\PromoCode;
use App\STLevel;
use App\STSwimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class STSwimmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $swimmer['promo_code_id'] = $this->validatePromoCode($request);

        $newSwimmer = STSwimmer::create($swimmer);

        Log::info("Swim Team Swimmer $newSwimmer->firstName $newSwimmer->lastName, ID: $newSwimmer->id has signed up for Level ID: $newSwimmer->s_t_level_id and is going to pay by card.");

        return redirect('/swim-team/checkout/'.$newSwimmer->id);
    }

    private function validatePromoCode(Request $request)
    {
        if(!empty($request->promo_code)){
            Log::info("Trying to find Promo for string: $request->promo_code");
            $userCode = strtoupper($request->promo_code);
            $promo = PromoCode::where('code', $userCode)->first();

            if(count($promo)){
                Log::info("Found Promo Code ID: $promo->id");
                return $promo->id;
            }
        } else {
            return null;
        }
    }

    public function checkout($id)
    {
        $swimmer = STSwimmer::find($id);
        return view('swim-team.checkOut', compact('swimmer'));
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

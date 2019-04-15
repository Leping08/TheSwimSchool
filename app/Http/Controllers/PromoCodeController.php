<?php

namespace App\Http\Controllers;

use App\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required'
        ]);

        $promoCode = PromoCode::where('code', '=', $validatedData['code'])->first() ?? null;

        if($promoCode){
            return $promoCode->discount_percent;
        } else {
            return 0;
        }
    }
}

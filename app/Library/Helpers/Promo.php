<?php

namespace App\Library\Helpers;

use Illuminate\Support\Facades\Log;

trait Promo
{
    public function validatePromoCode()
    {
        if (! empty(request()->promo_code)) {
            Log::info('Trying to find Promo for string:'.request()->promo_code);
            $userCode = trim(strtoupper(request()->promo_code));
            $promo = \App\PromoCode::where('code', $userCode)->first();

            if ($promo) {
                Log::info("Found Promo Code ID: $promo->id");

                return $promo;
            }
        }
    }
}

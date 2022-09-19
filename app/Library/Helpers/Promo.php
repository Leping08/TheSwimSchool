<?php

namespace App\Library\Helpers;

use App\PromoCode;
use Illuminate\Support\Facades\Log;

trait Promo
{
    /**
     * @return PromoCode
     */
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

        return null;
    }
}

<?php


namespace App\Library;


use Stripe\StripeObject;
use Stripe\Stripe;
use Stripe\Charge;

class StripeCharge
{
    public function getChargeDetails($chargeId) : StripeObject
    {
        if($chargeId){
            Stripe::setApiKey(env("STRIPE_SECRET"));

            Charge::retrieve($chargeId);
        } else {
            return NULL;
        }
    }
}
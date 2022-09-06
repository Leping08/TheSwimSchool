<?php

namespace App\Http\Controllers;

use App\PromoCode;
use App\STLevel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentIntentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'min:2', 'max:255'],
            'swimmer_id' => ['required', 'integer'],
            'level_id' => ['required', 'integer'],
            // 'promo_code' => ['sometimes', 'string', 'min:2', 'max:255'], // todo figure out the promo code validation better
        ]);
    
        // Get the price form the level id
        $level = STLevel::find($request->get('level_id'));
        $price = $level->price;
    
        // Apply promo code if promo code is provided
        if ($request->get('promo_code')) {
            $promoCode = PromoCode::where('code', $request->get('promo_code'))->first();
            $price = $promoCode->apply($price);
        }
    
        // This is your test secret API key.
        Stripe::setApiKey(config('services.stripe.secret'));
    
        // todo add try catch logic
        // Alternatively, set up a webhook to listen for the payment_intent.succeeded event
        // and attach the PaymentMethod to a new Customer
        $customer = Customer::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'metadata' => [
                'swimmer_id' => $request->get('swimmer_id'),
                'level_id' => $request->get('level_id'),
                'level_name' => $level->name,
            ]
        ]);

        Log::info('Stripe customer created: ' . $customer->id);

        // Create a PaymentIntent with amount and currency
        $paymentIntent = PaymentIntent::create([
            'customer' => $customer->id,
            'setup_future_usage' => 'off_session',
            'amount' => $price * 100, // amount in cents
            'currency' => 'usd',
            'automatic_payment_methods' => [
                'enabled' => true,
            ]
        ]);

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }
}

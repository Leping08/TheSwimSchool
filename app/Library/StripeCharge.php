<?php


namespace App\Library;


use Illuminate\Support\Facades\Log;
use App\Library\Interfaces\PaymentMethod;

/**
 * Class Stripe
 * @package App\Library
 */
class StripeCharge implements PaymentMethod
{
    public function buildCharge(string $token, int $price, string $email, string $description = null) : \Stripe\Charge
    {
        $charge = [
            "amount" => $price * 100,
            "currency" => "usd",
            "receipt_email" => $email,
            "description" => $description,
            "source" => $token //Obtained with Stripe.js
        ];

        Log::info('Stripe charge request array:');
        Log::info(print_r($charge, true));

        return $this->charge($charge);
    }


    private function logStripeError($e)
    {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        Log::error('Status is:' . $e->getHttpStatus());
        Log::error('Type is:' . $err['type']);
        Log::error('Code is:' . $err['code']);
        Log::error(print_r($err, true));
        session()->flash('error', 'Oops, something went wrong with the payment. ' . $err['message']);
        return back();
    }

    public function charge($charge) : \Stripe\Charge
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $result = \Stripe\Charge::create($charge);
            Log::info('Stripe charge ID: '.$result->id);
            return $result;
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            Log::error('Since its a decline, \Stripe\Error\Card will be caught');
            $this->logStripeError($e);
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            Log::error('Too many requests made to the API too quickly');
            $this->logStripeError($e);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::error('Invalid parameters were supplied to Stripes API');
            $this->logStripeError($e);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed (maybe you changed API keys recently)
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $this->logStripeError($e);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            Log::error('Network communication with Stripe failed');
            $this->logStripeError($e);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send yourself an email
            Log::error('Display a very generic error to the user, and maybe send yourself an email');
            $this->logStripeError($e);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            Log::error('Something else happened, completely unrelated to Stripe');
            Log::error('Error: ' . $e->getMessage());
            return back();
        }
    }

    public function getChargeDetails(string $chargeId) : ? \Stripe\Charge
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        return \Stripe\Charge::retrieve($chargeId);
    }

    public function test()
    {
        return 'Weee';
    }
}
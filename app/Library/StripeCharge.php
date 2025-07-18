<?php

namespace App\Library;

use App\Library\Interfaces\PaymentMethod;
use Illuminate\Support\Facades\Log;

/**
 * Class StripeCharge
 */
class StripeCharge implements PaymentMethod
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var int
     */
    public $price;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $description;

    /**
     * StripeCharge constructor.
     *
     * @param  string  $token
     * @param  int  $price
     * @param  string  $email
     * @param  string|null  $description
     */
    public function __construct(string $token, int $price, string $email, ?string $description = null)
    {
        $this->token = $token;
        $this->price = $price;
        $this->email = $email;
        $this->description = $description;
    }

    public function charge()
    {
        $charge = [
            'amount' => $this->price * 100,
            'currency' => 'usd',
            'receipt_email' => $this->email,
            'description' => $this->description,
            'source' => $this->token, // Obtained with Stripe.js
        ];

        Log::info('Stripe charge request array:');
        Log::info(print_r($charge, true));

        return $this->pay($charge);
    }

    /**
     * @param  array  $charge
     * @return mixed
     *
     * @throws \Exception
     */
    public function pay(array $charge)
    {
        try {
            Log::info('Setting API key');
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            Log::info('Stripe API key has been set');
            $result = $stripe->charges->create($charge);
            Log::info('Stripe charge complete');
            Log::info('Stripe charge ID: '.$result->id);

            return $result;
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            Log::error('Since it\'s a decline, \Stripe\Exception\CardException will be caught');
            $this->logStripeError($e);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            Log::error('Something else happened, completely unrelated to Stripe');
            Log::error('Error: '.$e->getMessage());
            Log::error('Get trace as string: '.$e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * @param  $e
     *
     * @throws \Exception
     */
    private function logStripeError($e)
    {
        $body = $e->getJsonBody();
        $err = $body['error'];
        Log::error('Status is:'.$e->getHttpStatus());
        Log::error('Type is:'.$err['type']);
        Log::error('Code is:'.$err['code']);
        Log::error(print_r($err, true));
        session()->flash('error', 'Oops, something went wrong with the payment. '.$err['message']);
        throw $e;
    }
}

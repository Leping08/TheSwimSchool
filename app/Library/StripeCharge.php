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
    public function __construct(string $token, int $price, string $email, string $description = null)
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
            'source' => $this->token, //Obtained with Stripe.js
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
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            Log::info('Stripe API key has been set');
            $result = \Stripe\Charge::create($charge);
            Log::info('Stripe charge complete');
            Log::info('Stripe charge ID: '.$result->id);

            return $result;
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            Log::error('Since it\'s a decline, \Stripe\Exception\CardException will be caught');
            $this->logStripeError($e);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            Log::error('Too many requests made to the API too quickly');
            $this->logStripeError($e);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::error('Invalid parameters were supplied to Stripes API');
            $this->logStripeError($e);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed (maybe you changed API keys recently)
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $this->logStripeError($e);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            Log::error('Network communication with Stripe failed');
            $this->logStripeError($e);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send yourself an email
            Log::error('Display a very generic error to the user, and maybe send yourself an email');
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
     * @param $e
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

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create a real PaymentIntent in the Stripe test account that was paid with a test card.
     */
    protected function createPaidPaymentIntent(int $amount = 5000): PaymentIntent
    {
        return (new StripeClient(config('services.stripe.secret')))->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method' => 'pm_card_visa',
            'confirm' => true,
            'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
        ]);
    }

    /**
     * Create a real PaymentIntent in the Stripe test account that was never paid.
     */
    protected function createUnpaidPaymentIntent(int $amount = 5000): PaymentIntent
    {
        return (new StripeClient(config('services.stripe.secret')))->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);
    }
}

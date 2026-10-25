<?php

namespace App\Library;

use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripePayment
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Charge a card PaymentMethod created by the Payment Element.
     *
     * Throws a CardException when the card is declined. When the bank requires 3D Secure the
     * PaymentIntent comes back as requires_action and the customer must be sent to redirectUrl().
     */
    public function charge(string $paymentMethodId, int $priceInDollars, string $email, string $description, string $returnUrl): PaymentIntent
    {
        return $this->stripe->paymentIntents->create([
            'amount' => $priceInDollars * 100,
            'currency' => 'usd',
            'payment_method' => $paymentMethodId,
            'payment_method_types' => ['card'],
            'confirm' => true,
            'receipt_email' => $email,
            'description' => $description,
            'return_url' => $returnUrl,
        ]);
    }

    public function retrieve(string $paymentIntentId): PaymentIntent
    {
        return $this->stripe->paymentIntents->retrieve($paymentIntentId);
    }

    public function refund(PaymentIntent $paymentIntent): void
    {
        $this->stripe->refunds->create(['payment_intent' => $paymentIntent->id]);
    }

    public static function requiresRedirect(PaymentIntent $paymentIntent): bool
    {
        return $paymentIntent->status === PaymentIntent::STATUS_REQUIRES_ACTION
            && $paymentIntent->next_action?->type === 'redirect_to_url';
    }

    public static function redirectUrl(PaymentIntent $paymentIntent): string
    {
        return $paymentIntent->next_action->redirect_to_url->url;
    }

    /**
     * Whether a PaymentIntent returned from 3D Secure was paid in full for the expected price.
     */
    public static function isPaid(PaymentIntent $paymentIntent, int $priceInDollars): bool
    {
        return $paymentIntent->status === PaymentIntent::STATUS_SUCCEEDED
            && $paymentIntent->amount === $priceInDollars * 100;
    }
}

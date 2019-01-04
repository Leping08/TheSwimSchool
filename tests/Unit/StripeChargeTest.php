<?php

namespace Tests\Unit;

use App\Library\StripeCharge;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripeChargeTest extends TestCase
{
    /** @test  **/
    public function it_will_charge_a_valid_credit_card()
    {
        $testCharge = collect([
            'card' => 'tok_visa',
            'price' => 85,
            'email' => 'derek@deltavcreative.com',
            'description' => "Testing the stripe API"
        ]);

        $charge = (new StripeCharge(
            $testCharge->get('card'),
            $testCharge->get('price'),
            $testCharge->get('email'),
            $testCharge->get('description')
        ))->charge();

        $this->assertInstanceOf(\Stripe\Charge::class, $charge);
        $this->assertArrayHasKey('id', $charge);
        $this->assertArrayHasKey('amount', $charge);
        $this->assertArrayHasKey('paid', $charge);
        $this->assertArrayHasKey('receipt_email', $charge);
        $this->assertArrayHasKey('description', $charge);
        $this->assertEquals(true, $charge->paid);
        $this->assertEquals($testCharge->get('email'), $charge->receipt_email);
        $this->assertEquals($testCharge->get('description'), $charge->description);
    }

    /** @test  **/
    public function it_will_catch_an_error_with_an_declined_card()
    {
        $testCharge = collect([
            'card' => 'tok_chargeDeclined',
            'price' => 85,
            'email' => 'derek@deltavcreative.com',
            'description' => "Testing the stripe API"
        ]);

        $charge = (new StripeCharge(
            $testCharge->get('card'),
            $testCharge->get('price'),
            $testCharge->get('email'),
            $testCharge->get('description')
        ))->charge();

        $this->assertEquals(null, $charge);
    }
}

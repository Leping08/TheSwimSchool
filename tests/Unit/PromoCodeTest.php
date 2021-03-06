<?php

namespace Tests\Unit;

use App\PromoCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function it_can_apply_a_discount_to_a_price()
    {
        $price = 100;

        $promoCode = PromoCode::factory()->create([
            'code' => 'HALFOFF',
            'discount_percent' => 50
        ]);

        $this->assertEquals($promoCode->apply($price), 50);



        $price2 = 200;

        $promoCode = PromoCode::factory()->create([
            'code' => 'HALFOFF',
            'discount_percent' => 75
        ]);

        $this->assertEquals($promoCode->apply($price2), 50);



        $price3 = 250;

        $promoCode = PromoCode::factory()->create([
            'code' => 'HALFOFF',
            'discount_percent' => 93
        ]);

        $this->assertEquals($promoCode->apply($price3), 17.50);
    }

    /** @test  **/
    public function it_should_not_change_the_price_if_the_discount_percent_is_0()
    {
        $price = 100;

        $promoCode = PromoCode::factory()->create([
            'code' => 'NONE',
            'discount_percent' => 0
        ]);

        $this->assertEquals($promoCode->apply($price), 100);
    }

    /** @test  **/
    public function it_should_make_the_price_0_if_the_discount_percent_is_100()
    {
        $price = 127;

        $promoCode = PromoCode::factory()->create([
            'code' => 'NONE',
            'discount_percent' => 100
        ]);

        $this->assertEquals($promoCode->apply($price), 0);
    }
}

<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\PromoCode::class, function (Faker $faker) {
    return [
        'code' => $faker->word,
        'discount_percent' => $faker->numberBetween(1, 100)
    ];
});

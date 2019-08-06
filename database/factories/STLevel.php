<?php

use Faker\Generator as Faker;

$factory->define(App\STLevel::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween(1, 400),
    ];
});

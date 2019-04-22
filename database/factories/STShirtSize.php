<?php

use Faker\Generator as Faker;

$factory->define(\App\STShirtSize::class, function (Faker $faker) {
    return [
        'size' => $faker->word,
    ];
});

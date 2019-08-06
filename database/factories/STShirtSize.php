<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\STShirtSize::class, function (Faker $faker) {
    return [
        'size' => $faker->word,
    ];
});

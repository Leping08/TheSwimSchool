<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\STShirtSize::class, function (Faker $faker) {
    return [
        'size' => $faker->word,
    ];
});

<?php

use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Review::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'active' => true,
        'created_time' => $faker->unique()->randomDigit,
        'message' => $faker->sentence,
    ];
});

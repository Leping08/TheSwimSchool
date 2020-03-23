<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Banner::class, function (Faker $faker) {
    return [
        'active' => true,
        'page' => '/swim-team',
        'text' => $faker->sentence
    ];
});

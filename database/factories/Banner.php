<?php

use Faker\Generator as Faker;

$factory->define(\App\Banner::class, function (Faker $faker) {
    return [
        'active' => true,
        'page' => '/swim-team',
        'text' => $faker->sentence
    ];
});

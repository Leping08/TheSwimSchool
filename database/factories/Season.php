<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'year' => '2017',
        'season' => 'fall'
    ];
});

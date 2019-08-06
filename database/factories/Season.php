<?php

use Faker\Generator as Faker;

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'year' => '2017',
        'season' => 'fall',
    ];
});

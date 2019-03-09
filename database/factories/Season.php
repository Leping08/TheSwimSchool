<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Season::class, function (Faker $faker) {
    return [
        'year' => '2017',
        'season' => 'fall'
    ];
});

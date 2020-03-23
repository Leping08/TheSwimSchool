<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\PrivateLesson::class, function (Faker $faker) {
    return [
        'season_id' => factory(\App\Season::class)
    ];
});

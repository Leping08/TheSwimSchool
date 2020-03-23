<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\STSeason::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'dates' => $faker->word,
        'current_season' => true
    ];
});

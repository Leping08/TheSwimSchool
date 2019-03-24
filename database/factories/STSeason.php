<?php

use Faker\Generator as Faker;

$factory->define(\App\STSeason::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'dates' => $faker->word,
        'current_season' => true
    ];
});

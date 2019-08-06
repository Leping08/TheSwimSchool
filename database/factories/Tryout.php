<?php

use Faker\Generator as Faker;

$factory->define(\App\Tryout::class, function (Faker $faker) {
    return [
        's_t_season_id' => factory(\App\STSeason::class)->create()->id,
        'location_id' => factory(\App\Location::class)->create()->id,
        'registration_open' => $faker->dateTimeBetween('-1 month', 'yesterday'),
        'event_time' => $faker->dateTimeBetween('tomorrow', '+1 week'),
    ];
});

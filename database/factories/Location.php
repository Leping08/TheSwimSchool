<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->word,
        'zip' => $faker->randomNumber(5),
        'phoneNumber' => $faker->phoneNumber
    ];
});

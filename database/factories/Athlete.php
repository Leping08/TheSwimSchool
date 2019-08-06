<?php

use Faker\Generator as Faker;

$factory->define(App\Athlete::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber,
        'birthDate' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
        'tryout_id' => factory(\App\Tryout::class)->create()->id,
        'parent' => $faker->name,
        'notes' => $faker->paragraph,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'state' => $faker->word,
        'zip' => $faker->postcode,
        'emergencyName' => $faker->firstNameFemale,
        'emergencyRelationship' => 'Mom',
        'emergencyPhone' => $faker->phoneNumber,
        's_t_season_id' => factory(\App\STSeason::class)->create()->id,
        's_t_sign_up_email' => false,
    ];
});

<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\PrivateSwimmer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber,
        'parent' => $faker->name,
        'notes' => $faker->paragraph,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'state' => $faker->word,
        'zip' => $faker->postcode,
        'emergency_name' => $faker->firstNameFemale,
        'emergency_relationship' => 'Mom',
        'emergency_phone' => $faker->phoneNumber,
        'stripe_charge_id' => 'ch_' . $faker->bothify('##??##??##??##??##??##??##??##??'),
        'private_lesson_id' => factory(\App\PrivateLesson::class)
    ];
});

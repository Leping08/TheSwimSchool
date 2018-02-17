<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Swimmer::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phone' => $faker->phoneNumber,
        'paid' => $faker->boolean,
        'birthDate' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'lesson_id' => factory('App\Lesson')->create()->id,
        'parent' => $faker->name,
        'notes' => $faker->paragraph,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'state' => $faker->word,
        'zip' => $faker->postcode,
        'emergencyName' => $faker->firstNameFemale,
        'emergencyRelationship' => 'Mom',
        'emergencyPhone' => $faker->phoneNumber,
        //'stripechargeid' => $faker->creditCardNumber
    ];
});

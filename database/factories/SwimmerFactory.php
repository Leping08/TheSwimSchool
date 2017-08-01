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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'paid' => $faker->boolean,
        'age' => $faker->numberBetween(1, 100),
        'lesson_id' => $faker->numberBetween(1, 12),
        'parent' => $faker->name,
        'notes' => $faker->paragraph,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'emergencyName' => $faker->firstNameFemale,
        'emergencyRelationship' => 'Mom',
        'emergencyPhone' => $faker->phoneNumber,
        'stripechargeid' => $faker->creditCardNumber
    ];
});

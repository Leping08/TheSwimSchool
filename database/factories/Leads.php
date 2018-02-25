<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'contact_type_id' => $faker->numberBetween(1,4),
        'message' => $faker->paragraph(),
    ];
});

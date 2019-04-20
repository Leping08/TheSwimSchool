<?php

use Faker\Generator as Faker;

$factory->define(App\STCoach::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => '9998887777',
        'active' => true,
        'bio' => $faker->paragraph
    ];
});

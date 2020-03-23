<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'type' => $faker->word,
        'ages' => "6 years old",
        'icon' => $faker->word,
        'description' => $faker->paragraph
    ];
});

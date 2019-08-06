<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Group::class, function (Faker $faker) {
    return [
        'type' => $faker->word,
        'ages' => '6 years old',
        'icon' => $faker->word,
        'description' => $faker->paragraph,
    ];
});

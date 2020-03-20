<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\EmailList::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'subscribe' => 1
    ];
});

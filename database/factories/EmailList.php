<?php

use Faker\Generator as Faker;

$factory->define(App\EmailList::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'subscribe' => 1
    ];
});

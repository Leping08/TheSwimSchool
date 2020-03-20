<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\PrivatePoolSession::class, function (Faker $faker) {
    return [
        'start' => \Carbon\Carbon::now(),
        'end' => \Carbon\Carbon::now()->addHour(),
        'private_lesson_id' => factory(\App\PrivateLesson::class),
        'location_id' => factory(\App\Location::class)
    ];
});

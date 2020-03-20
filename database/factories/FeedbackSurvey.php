<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\FeedbackSurvey::class, function (Faker $faker) {
    return [
        'viewed' => false
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(\App\FeedbackSurvey::class, function (Faker $faker) {
    return [
        'viewed' => false
    ];
});

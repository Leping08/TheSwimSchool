<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\FeedbackSurvey::class, function (Faker $faker) {
    return [
        'viewed' => false,
    ];
});

<?php

namespace Database\Factories;

use App\PageParameters;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageParametersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageParameters::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'configuration' => [],
        ];
    }

    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function customNewsLetter()
    {
        return $this->state([
            'name' => "News Letter Email",
            'configuration' => [
              "subject" => "Email Subject",
              "image_url" => "https://d36u81tzit3s7e.cloudfront.net/ffe8be63-1407-4f2a-8e24-4742e23db075/img/lessons/private.jpg",
              "button_url" => "https://theswimschoolfl.com/lesson",
              "button_text" => "Learn More",
              "body_text" => "# New Year, New Business Phone Number!\nI hope you all had a wonderful holiday season! My staff and I look forward to seeing you back in the pool very soon! Before we dive into 2022, I wanted to let you know we are starting off the new year with a new phone number! The Swim School now has an official business phone line and the new number is **Phone Number**.",
              "preview_email_address" => "testing@gmail.com"
            ]
        ]);
    }
}
<?php

namespace Tests\Feature;

use App\Review;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReviewsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  **/
    public function a_user_should_see_active_reviews_on_the_home_page()
    {
        $firstReview = Review::factory()->create([
            'active' => true,
            'created_time' => '2016-05-12T16:23:21+0000'
        ]);

        $secondReview = Review::factory()->create([
            'active' => true,
            'created_time' => '2016-05-13T16:23:21+0000'
        ]);

        $this->get(route('home.index'))
            ->assertSee("Testimonials")
            ->assertSee($firstReview->message)
            ->assertSee($secondReview->message);
    }

    /** @test  **/
    public function a_user_should_not_see_disabled_reviews_on_the_home_page()
    {
        $review = Review::factory()->create([
            'created_time' => '2016-05-14T14:23:21+0000',
            'active' => true
        ]);

        $this->get(route('home.index'))
            ->assertSee($review->message);

        $review->active = false;
        $review->save();

        $this->artisan('cache:clear');

        $this->get(route('home.index'))
            ->assertDontSee($review->message);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReviewsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  **/
    public function a_user_should_see_active_reviews_on_the_home_page()
    {
        $firstReview = factory('App\Review')->create([
            'created_time' => '2016-05-12T16:23:21+0000',
        ]);

        $secondReview = factory('App\Review')->create([
            'created_time' => '2016-05-13T16:23:21+0000',
        ]);

        $this->get('/')
            ->assertSee('Testimonials')
            ->assertSee($firstReview->message)
            ->assertSee($secondReview->message);
    }

    /** @test  **/
    public function a_user_should_not_see_disabled_reviews_on_the_home_page()
    {
        $review = factory('App\Review')->create([
            'created_time' => '2016-05-14T14:23:21+0000',
            'active' => true,
        ]);

        $this->get('/')
            ->assertSee($review->message);

        $review->active = false;
        $review->save();

        $this->get('/')
            ->assertDontSee($review->message);
    }
}

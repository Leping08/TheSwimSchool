<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmailListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_should_be_able_to_unsubscribe_by_hitting_the_unsubscribe_page()
    {
        //Set up an email
        $email = factory('App\EmailList')->create([
            'email' => 'test@testing.com'
        ]);
        //Make sure the email is subscribed
        $this->assertEquals(1, $email->subscribe);
        //Get the route to unsubscribe
        $this->get("/unsubscribe/$email->email")
            ->assertSee('The email address test@testing.com has been unsubscribed from all marketing emails');
        //Get a fresh instance of the email
        $email = \App\EmailList::first();
        //Make sure the email is unsubscribed
        $this->assertEquals(0, $email->subscribe);

    }
}

<?php


namespace Tests\Feature;


use App\EmailList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsLetterTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function it_allows_someone_to_sign_up()
    {
        $data = [
            'email' => $this->faker->safeEmail
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());
    }

    /** @test  **/
    public function it_will_not_throw_an_error_when_the_same_email_is_entered_twice()
    {
        $data = [
            'email' => $this->faker->safeEmail
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());
    }
}
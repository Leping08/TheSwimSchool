<?php


namespace Tests\Feature;


use App\EmailList;
use App\Library\Mailgun\Mailgun;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
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

    /** @test  **/
    public function it_will_remove_all_emails_that_have_submitted_complaints_before_sending_news_letter_emails()
    {
        $email_subscribed = $this->faker->safeEmail();

        EmailList::create([
            'email' => $email_subscribed,
            'subscribe' => true
        ]);

        $fake_response = [
            'items' => [
                [
                    'address' => $email_subscribed,
                    'created_at' => 'Mon, 11 Oct 2021 13:48:43 UTC',
                ]
            ]
        ];

        Http::fake([
            'api.mailgun.net/v3/theswimschoolfl.com/complaints' => Http::response($fake_response, 200)
        ]);

        $email_before = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(1, $email_before->subscribe);

        Mailgun::removeComplaintsEmails();

        $email_after = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(0, $email_after->subscribe);
    }

    /** @test  **/
    public function it_can_handle_an_api_error_to_mailgun()
    {
        $email_subscribed = $this->faker->safeEmail();

        EmailList::create([
            'email' => $email_subscribed,
            'subscribe' => true
        ]);

        $fake_response = "An error happened";

        Http::fake([
            'api.mailgun.net/v3/theswimschoolfl.com/complaints' => Http::response($fake_response, 400)
        ]);

        $email_before = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(1, $email_before->subscribe);

        Mailgun::removeComplaintsEmails();

        $email_after = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(1, $email_after->subscribe);
    }
}
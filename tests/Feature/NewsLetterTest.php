<?php

namespace Tests\Feature;

use App\EmailList;
use App\Library\Mailgun\Mailgun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsLetterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function it_allows_someone_to_sign_up()
    {
        $data = [
            'email' => $this->faker->safeEmail,
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());
    }

    #[Test]
    public function it_will_not_throw_an_error_when_the_same_email_is_entered_twice()
    {
        $data = [
            'email' => $this->faker->safeEmail,
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());
    }

    #[Test]
    public function it_will_remove_all_emails_that_have_submitted_complaints_before_sending_news_letter_emails()
    {
        $email_subscribed = $this->faker->safeEmail();

        EmailList::create([
            'email' => $email_subscribed,
            'subscribe' => true,
        ]);

        $fake_response = [
            'items' => [
                [
                    'address' => $email_subscribed,
                    'created_at' => 'Mon, 11 Oct 2021 13:48:43 UTC',
                ],
            ],
        ];

        Http::fake([
            'api.mailgun.net/v3/theswimschoolfl.com/complaints?limit=1000' => Http::response($fake_response, 200),
        ]);

        $email_before = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(true, $email_before->subscribe);

        Mailgun::removeComplaintsEmails();

        $email_after = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(false, $email_after->subscribe);
    }

    #[Test]
    public function it_can_handle_an_api_error_to_mailgun()
    {
        $email_subscribed = $this->faker->safeEmail();

        EmailList::create([
            'email' => $email_subscribed,
            'subscribe' => true,
        ]);

        $fake_response = 'An error happened';

        Http::fake([
            'api.mailgun.net/v3/theswimschoolfl.com/complaints' => Http::response($fake_response, 400),
        ]);

        $email_before = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(true, $email_before->subscribe);

        Mailgun::removeComplaintsEmails();

        $email_after = EmailList::where('email', $email_subscribed)->first();
        $this->assertEquals(true, $email_after->subscribe);
    }

    #[Test]
    public function it_will_not_allow_someone_to_sign_up_if_a_honeypot_field_is_filled_out()
    {
        $data = [
            'email' => $this->faker->safeEmail,

            // honeypot field
            'email_address' => $this->faker->safeEmail,
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(0, EmailList::all());
    }

    #[Test]
    public function it_will_not_allow_someone_to_sign_up_if_they_move_too_fast_like_a_bot()
    {
        $data = [
            'email' => $this->faker->safeEmail,
            'time' => Carbon::now()->timestamp,
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(0, EmailList::all());
    }

    #[Test]
    public function it_will_allow_someone_to_sign_up_if_they_at_human_speeds()
    {
        $data = [
            'email' => $this->faker->safeEmail,
            'time' => Carbon::now()->timestamp - 5,
        ];

        $this->assertCount(0, EmailList::all());

        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        $this->assertCount(1, EmailList::all());
    }

    #[Test]
    public function it_allows_someone_resubscribe_with_the_same_email()
    {
        $safeEmail = $this->faker->safeEmail();

        EmailList::create([
            'email' => $safeEmail,
            'subscribe' => false,
        ]);

        // Assert the email is not subscribed
        $this->assertCount(1, EmailList::all());
        $this->assertEquals(false, EmailList::where('email', $safeEmail)->first()->subscribe);

        $data = [
            'email' => $safeEmail,
            'time' => Carbon::now()->timestamp - 5,
        ];

        // Run the resubscribe
        $this->post(route('newsletter.subscribe'), $data)
            ->assertStatus(302);

        // Assert that the email is subscribed
        $this->assertCount(1, EmailList::all());
        $this->assertEquals(true, EmailList::where('email', $safeEmail)->first()->subscribe);
    }
}

<?php

namespace Tests\Feature;

use App\EmailList;
use App\Jobs\NewsLetter\QueueCustomNewsLetterEmails;
use App\Jobs\NewsLetter\SendCustomNewsLetterEmail;
use App\Mail\NewsLetter\CustomNewsLetter;
use App\PageParameters;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CustomNewsLetterEmailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  **/
    public function a_user_must_be_logged_in_to_see_the_edit_email_page()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('newsletter.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->actingAs($user);

        $this->get(route('newsletter.index'))
           ->assertStatus(200);
    }

    /** @test */
    public function a_user_should_be_able_to_render_the_email_if_all_the_prams_are_sent_to_the_preview_route()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        // Set up the news letter email in the db
        $customNewsLetter = [
            'subject' => $this->faker->word,
            'image_url' => $this->faker->imageUrl,
            'button_url' => $this->faker->url,
            'button_text' => $this->faker->word,
            'body_text' => $this->faker->paragraph,
            'preview_email_address' => $this->faker->safeEmail,
        ];

        $this->json('POST', route('newsletter.preview.view'), [
            'subject' => $customNewsLetter['subject'],
            'body_text' => $customNewsLetter['body_text'],
            'image_url' => $customNewsLetter['image_url'],
            'button_url' => $customNewsLetter['button_url'],
            'button_text' => $customNewsLetter['button_text'],
            'preview_email_address' => $customNewsLetter['preview_email_address'],
        ])
        ->assertStatus(200)
        ->assertSee($customNewsLetter['body_text'])
        ->assertSee($customNewsLetter['image_url'])
        ->assertSee($customNewsLetter['button_url'])
        ->assertSee($customNewsLetter['button_text'])
        ->assertSee($customNewsLetter['preview_email_address']);
    }

    /** @test */
    public function a_user_should_be_able_to_send_a_preview_email_to_the_email_in_the_request_params()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        Mail::fake();
        Mail::assertNothingSent();

        // Set up the news letter email in the db
        $customNewsLetter = [
            'subject' => $this->faker->word,
            'image_url' => $this->faker->imageUrl,
            'button_url' => $this->faker->url,
            'button_text' => $this->faker->word,
            'body_text' => $this->faker->paragraph,
            'preview_email_address' => $this->faker->safeEmail,
        ];

        PageParameters::factory()
            ->create([
                'name' => 'News Letter Email',
                'configuration' => [
                    'subject' => $customNewsLetter['subject'],
                    'body_text' => $customNewsLetter['body_text'],
                    'image_url' => $customNewsLetter['image_url'],
                    'button_url' => $customNewsLetter['button_url'],
                    'button_text' => $customNewsLetter['button_text'],
                    'preview_email_address' => $customNewsLetter['preview_email_address'],
                ],
            ]);

        $previewEmail = $this->faker->safeEmail;

        $this->json('POST', route('newsletter.preview.send'), [
            'preview_email_address' => $previewEmail,
        ])
          ->assertStatus(200);

        Mail::assertSent(CustomNewsLetter::class, function ($mail) use ($previewEmail) {
            return $mail->hasTo($previewEmail);
        });
    }

    /** @test */
    public function a_user_should_be_update_the_email_content_by_hitting_the_route()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        // Set up the news letter email in the db
        $customNewsLetter_1 = [
            'subject' => $this->faker->word,
            'image_url' => $this->faker->imageUrl,
            'button_url' => $this->faker->url,
            'button_text' => $this->faker->word,
            'body_text' => $this->faker->paragraph,
            'preview_email_address' => $this->faker->safeEmail,
        ];

        $customNewsLetter_2 = [
            'subject' => $this->faker->word,
            'image_url' => $this->faker->imageUrl,
            'button_url' => $this->faker->url,
            'button_text' => $this->faker->word,
            'body_text' => $this->faker->paragraph,
            'preview_email_address' => $this->faker->safeEmail,
        ];

        PageParameters::factory()->customNewsLetter()->create();

        $this->json('POST', route('newsletter.store'), [
            'subject' => $customNewsLetter_1['subject'],
            'body_text' => $customNewsLetter_1['body_text'],
            'image_url' => $customNewsLetter_1['image_url'],
            'button_url' => $customNewsLetter_1['button_url'],
            'button_text' => $customNewsLetter_1['button_text'],
            'preview_email_address' => $customNewsLetter_1['preview_email_address'],
        ])
        ->assertStatus(200)
        ->assertSee($customNewsLetter_1['body_text'])
        ->assertSee($customNewsLetter_1['button_text'])
        ->assertSee($customNewsLetter_1['preview_email_address']);

        $this->get(route('newsletter.show'))
        ->assertStatus(200)
        ->assertSee($customNewsLetter_1['body_text'])
        ->assertSee($customNewsLetter_1['button_text'])
        ->assertSee($customNewsLetter_1['preview_email_address']);

        $this->json('POST', route('newsletter.store'), [
            'subject' => $customNewsLetter_2['subject'],
            'body_text' => $customNewsLetter_2['body_text'],
            'image_url' => $customNewsLetter_2['image_url'],
            'button_url' => $customNewsLetter_2['button_url'],
            'button_text' => $customNewsLetter_2['button_text'],
            'preview_email_address' => $customNewsLetter_2['preview_email_address'],
        ])
        ->assertStatus(200)
        ->assertSee($customNewsLetter_2['body_text'])
        ->assertSee($customNewsLetter_2['button_text'])
        ->assertSee($customNewsLetter_2['preview_email_address']);
    }

    /** @test */
    public function a_user_should_send_the_news_letter_out_to_everyone_on_the_newsletter_email_list()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        EmailList::factory()->count(3)->create();
        EmailList::factory()->count(3)->create([
            'subscribe' => false,
        ]);

        $fake_response = [
            'items' => [
                [
                    'address' => $this->faker->safeEmail,
                    'created_at' => 'Mon, 11 Oct 2021 13:48:43 UTC',
                ],
            ],
        ];

        Http::fake([
            'api.mailgun.net/v3/theswimschoolfl.com/complaints' => Http::response($fake_response, 200),
        ]);

        Queue::fake();

        Queue::assertNothingPushed();

        PageParameters::factory()->customNewsLetter()->create();

        $this->json('POST', route('newsletter.send'))
        ->assertStatus(200);

        Queue::assertPushed(QueueCustomNewsLetterEmails::class);
    }

    /** @test */
    public function the_send_custom_news_letter_email_job_does_send_the_email()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        Mail::fake();
        Mail::assertNothingSent();

        $email = $this->faker->safeEmail;

        // Set up the news letter email in the db
        $customNewsLetter = [
            'subject' => $this->faker->word,
            'image_url' => $this->faker->imageUrl,
            'button_url' => $this->faker->url,
            'button_text' => $this->faker->word,
            'body_text' => $this->faker->paragraph,
            'preview_email_address' => $this->faker->safeEmail,
        ];

        $pageParameters = PageParameters::factory()
            ->create([
                'name' => 'News Letter Email',
                'configuration' => [
                    'subject' => $customNewsLetter['subject'],
                    'body_text' => $customNewsLetter['body_text'],
                    'image_url' => $customNewsLetter['image_url'],
                    'button_url' => $customNewsLetter['button_url'],
                    'button_text' => $customNewsLetter['button_text'],
                    'preview_email_address' => $customNewsLetter['preview_email_address'],
                ],
            ]);

        Mail::assertNothingSent();

        SendCustomNewsLetterEmail::dispatch($email, $pageParameters);

        Mail::assertSent(CustomNewsLetter::class);
    }
}

<?php

namespace Tests\Feature;

use App\Jobs\SendPrivatePoolSessionReminderEmails;
use App\Library\StripePayment;
use App\Mail\Privates\PrivateLessonSignUp;
use App\Mail\Privates\PrivatePoolSessionReminder;
use App\PoolSession;
use App\PrivateLesson;
use App\PrivateSwimmer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Stripe\StripeClient;
use Tests\TestCase;

class PrivateLessonCalendarRequestTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    #[Test]
    public function a_user_can_request_a_private_lesson_with_more_than_one_pool_session()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $sessions = PoolSession::factory()->count(4)->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $session_ids = $sessions->implode('id', ',');

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '2018-2-1',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids,
            'payment_method' => 'pm_card_visa',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $response = $this->post(route('private_lesson.store'), $data);

        $response->assertStatus(302);

        $this->assertEquals(1, PrivateLesson::all()->count());
        $this->assertEquals(4, PrivateLesson::first()->pool_sessions()->count());

        $this->assertDatabaseHas('private_swimmers', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'emergency_name' => $data['emergency_name'],
            'emergency_relationship' => $data['emergency_relationship'],
            'emergency_phone' => $data['emergency_phone'],
        ]);

        Mail::assertSent(PrivateLessonSignUp::class);
    }

    #[Test]
    public function a_user_can_request_a_private_lesson_with_one_pool_session()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $session_ids = (string) $session->id;

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '2018-2-1',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids,
            'payment_method' => 'pm_card_visa',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $response = $this->post(route('private_lesson.store'), $data);

        $response->assertStatus(302);

        $this->assertEquals(1, PrivateLesson::all()->count());

        $this->assertDatabaseHas('private_swimmers', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'emergency_name' => $data['emergency_name'],
            'emergency_relationship' => $data['emergency_relationship'],
            'emergency_phone' => $data['emergency_phone'],
        ]);

        Mail::assertSent(PrivateLessonSignUp::class);
    }

    #[Test]
    public function the_system_will_send_out_a_reminder_email_to_swimmers_with_lessons_tomorrow()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $lesson = PrivateLesson::factory()->create();

        $private_swimmer = PrivateSwimmer::factory()->create([
            'private_lesson_id' => $lesson->id,
        ]);

        $pool_session = PoolSession::factory()->create([
            'pool_session_id' => $lesson->id,
            'pool_session_type' => PrivateLesson::class,
            'start' => Carbon::tomorrow(),
        ]);

        $pool_session2 = PoolSession::factory()->create([
            'pool_session_id' => $lesson->id,
            'pool_session_type' => PrivateLesson::class,
            'start' => Carbon::now()->addWeek(),
        ]);

        SendPrivatePoolSessionReminderEmails::dispatch();

        Mail::assertSent(PrivatePoolSessionReminder::class, 1);
    }

    #[Test]
    public function a_user_can_only_sign_up_for_a_private_lesson_that_is_available()
    {
        $this->seed();

        $next_week = PoolSession::factory()->create([
            'start' => Carbon::now()->addDay(),
            'end' => Carbon::now()->addDay()->addHour(),
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $last_week = PoolSession::factory()->create([
            'start' => Carbon::now()->subWeek(),
            'end' => Carbon::now()->subWeek()->subHour(),
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $this->get(route('private_lesson.index'))
            ->assertStatus(200)
            ->assertSee($next_week->start->toJSON())
            ->assertDontSee($last_week->start->toJSON());
    }

    #[Test]
    public function a_user_will_see_an_error_message_if_the_card_is_declined()
    {
        $this->seed();

        // $this->withoutExceptionHandling();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $session_ids = (string) $session->id;

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '2018-2-1',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids,
            'payment_method' => 'pm_card_chargeDeclined',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $this->post(route('private_lesson.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas('error', 'Oops, something went wrong with the payment. Your card was declined.');

        $this->assertEquals(0, PrivateLesson::all()->count());
    }

    #[Test]
    public function a_user_can_sign_up_with_this_birth_date_format()
    {
        $this->seed();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $session_ids = (string) $session->id;

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '09/08/2016',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids,
            'payment_method' => 'pm_card_visa',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $response = $this->post(route('private_lesson.store'), $data);

        $response->assertStatus(302);

        $this->assertEquals(1, PrivateLesson::all()->count());
        $this->assertEquals(1, PrivateLesson::first()->pool_sessions()->count());
    }

    #[Test]
    public function a_user_can_not_sign_up_for_a_lesson_that_has_been_taken_by_someone_else()
    {
        $this->seed();

        PoolSession::factory()->count(4)->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        // This is the same id that was already signed up for
        $session_ids_1 = '1';

        $data_1 = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '09/08/2016',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids_1,
            'payment_method' => 'pm_card_visa',
        ];

        $response = $this->post(route('private_lesson.store'), $data_1);

        $response->assertStatus(302);
        $response->assertRedirect(route('pages.thank-you'));

        $this->assertCount(1, PrivateSwimmer::all());

        // This is the same id that was already signed up for
        $session_ids_2 = '1';

        $data_2 = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '09/08/2016',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $session_ids_2,
            'payment_method' => 'pm_card_visa',
        ];

        $response = $this->post(route('private_lesson.store'), $data_2);

        $response->assertStatus(302);
        $response->assertRedirect(route('private_lesson.index'));

        // Assert the user was not created
        $this->assertCount(1, PrivateSwimmer::all());
    }

    #[Test]
    public function a_user_is_sent_to_their_bank_when_the_card_requires_3d_secure()
    {
        $this->seed();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);

        $response = $this->post(route('private_lesson.store'), $this->signUpData((string) $session->id, 'pm_card_threeDSecure2Required'));

        $this->assertStringStartsWith('https://hooks.stripe.com/', $response->headers->get('Location'));
        $this->assertCount(1, session('private_lesson_payments'));
        $this->assertEquals(0, PrivateLesson::all()->count());
    }

    #[Test]
    public function a_user_is_signed_up_once_after_completing_3d_secure()
    {
        Mail::fake();

        $this->seed();

        $sessions = PoolSession::factory()->count(2)->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
            'price' => 40,
        ]);
        $paymentIntent = (new StripePayment)->charge('pm_card_visa', 80, 'test@example.com', 'Test', route('private_lesson.payment-complete'));
        $data = $this->signUpData($sessions->implode('id', ','), 'pm_card_visa');

        $this->withSession(['private_lesson_payments' => [$paymentIntent->id => ['registration' => $data, 'pool_session_ids' => $sessions->pluck('id')->map(fn ($id) => (string) $id)->all(), 'price' => 80]]])
            ->get(route('private_lesson.payment-complete', ['payment_intent' => $paymentIntent->id]))
            ->assertRedirect(route('pages.thank-you'));

        $this->assertEquals(1, PrivateLesson::all()->count());
        $this->assertEquals(2, PrivateLesson::first()->pool_sessions()->count());
        $this->assertDatabaseHas('private_swimmers', [
            'first_name' => $data['first_name'],
            'stripe_charge_id' => $paymentIntent->id,
        ]);
        Mail::assertSent(PrivateLessonSignUp::class);

        // Refreshing the return page does not sign the swimmer up twice
        $this->get(route('private_lesson.payment-complete', ['payment_intent' => $paymentIntent->id]))
            ->assertRedirect(route('pages.thank-you'));

        $this->assertEquals(1, PrivateLesson::all()->count());
    }

    #[Test]
    public function a_user_is_not_signed_up_when_3d_secure_is_not_completed()
    {
        $this->seed();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);
        $paymentIntent = (new StripePayment)->charge('pm_card_threeDSecure2Required', 35, 'test@example.com', 'Test', route('private_lesson.payment-complete'));

        $this->withSession(['private_lesson_payments' => [$paymentIntent->id => ['registration' => $this->signUpData((string) $session->id, 'pm_card_threeDSecure2Required'), 'pool_session_ids' => [(string) $session->id], 'price' => 35]]])
            ->get(route('private_lesson.payment-complete', ['payment_intent' => $paymentIntent->id]))
            ->assertRedirect(route('private_lesson.index'))
            ->assertSessionHas('error');

        $this->assertEquals(0, PrivateLesson::all()->count());
        $this->assertNull($session->fresh()->pool_session_id);
    }

    #[Test]
    public function a_user_is_refunded_when_their_lesson_is_taken_during_3d_secure()
    {
        $this->seed();

        $session = PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
        ]);
        $paymentIntent = (new StripePayment)->charge('pm_card_visa', 35, 'test@example.com', 'Test', route('private_lesson.payment-complete'));

        // Someone else books the session while this user is at their bank
        $session->update(['pool_session_id' => PrivateLesson::create(['season_id' => 1])->id]);

        $this->withSession(['private_lesson_payments' => [$paymentIntent->id => ['registration' => $this->signUpData((string) $session->id, 'pm_card_visa'), 'pool_session_ids' => [(string) $session->id], 'price' => 35]]])
            ->get(route('private_lesson.payment-complete', ['payment_intent' => $paymentIntent->id]))
            ->assertRedirect(route('private_lesson.index'))
            ->assertSessionHas('warning', 'Sorry, one of the classes was already taken. Your payment has been refunded.');

        $this->assertCount(0, PrivateSwimmer::all());
        $this->assertTrue((new StripeClient(config('services.stripe.secret')))->paymentIntents->retrieve($paymentIntent->id, ['expand' => ['latest_charge']])->latest_charge->refunded);
    }

    #[Test]
    public function a_user_is_charged_the_sum_of_the_pool_session_prices()
    {
        $this->seed();

        $sessions = collect([40, null])->map(fn ($price) => PoolSession::factory()->create([
            'pool_session_id' => null,
            'pool_session_type' => PrivateLesson::class,
            'price' => $price,
        ]));

        $this->post(route('private_lesson.store'), $this->signUpData($sessions->implode('id', ','), 'pm_card_visa'))
            ->assertRedirect(route('pages.thank-you'));

        $paymentIntent = (new StripePayment)->retrieve(PrivateSwimmer::first()->stripe_charge_id);

        $this->assertEquals(7500, $paymentIntent->amount);
        $this->assertEquals('succeeded', $paymentIntent->status);
    }

    /**
     * @return array<string, mixed>
     */
    private function signUpData(string $poolSessionIds, string $paymentMethod): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '2018-2-1',
            'email' => $this->faker->safeEmail,
            'phone' => '999-999-9999',
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => '999-999-9999',
            'pool_session_ids' => $poolSessionIds,
            'payment_method' => $paymentMethod,
        ];
    }
}

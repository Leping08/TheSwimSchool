<?php

namespace Tests\Feature;

use App\Jobs\SendPrivatePoolSessionReminderEmails;
use App\Mail\Privates\PrivateLessonSignUp;
use App\Mail\Privates\PrivatePoolSessionReminder;
use App\PrivateLesson;
use App\PrivatePoolSession;
use App\PrivateSwimmer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PrivateLessonCalendarRequestTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_can_request_a_private_lesson_with_more_than_one_pool_session()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $sessions = PrivatePoolSession::factory()->count(4)->create([
            'private_lesson_id' => null,
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
            'stripe_token' => 'tok_visa',
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

    /** @test  **/
    public function a_user_can_request_a_private_lesson_with_one_pool_session()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $session = PrivatePoolSession::factory()->create([
            'private_lesson_id' => null,
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
            'stripe_token' => 'tok_visa',
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

    /** @test  **/
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

        $pool_session = PrivatePoolSession::factory()->create([
            'private_lesson_id' => $lesson->id,
            'start' => Carbon::tomorrow(),
        ]);

        $pool_session2 = PrivatePoolSession::factory()->create([
            'private_lesson_id' => $lesson->id,
            'start' => Carbon::now()->addWeek(),
        ]);

        SendPrivatePoolSessionReminderEmails::dispatch();

        Mail::assertSent(PrivatePoolSessionReminder::class, 1);
    }

    /** @test  **/
    public function a_user_can_only_sign_up_for_a_private_lesson_that_is_available()
    {
        $this->seed();

        $next_week = PrivatePoolSession::factory()->create([
            'start' => Carbon::now()->addWeek(),
            'end' => Carbon::now()->addWeek()->addHour(),
            'private_lesson_id' => null,
        ]);

        $last_week = PrivatePoolSession::factory()->create([
            'start' => Carbon::now()->subWeek(),
            'end' => Carbon::now()->subWeek()->subHour(),
            'private_lesson_id' => null,
        ]);

        $this->get(route('private_lesson.index'))
            ->assertStatus(200)
            ->assertSee($next_week->start->toJSON())
            ->assertDontSee($last_week->start->toJSON());
    }

    /** @test  **/
    public function a_user_will_see_an_error_message_if_the_card_is_declined()
    {
        $this->seed();

        //$this->withoutExceptionHandling();

        $session = PrivatePoolSession::factory()->create([
            'private_lesson_id' => null,
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
            'stripe_token' => 'tok_chargeDeclined',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $this->post(route('private_lesson.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas('error', 'Oops, something went wrong with the payment. Your card was declined.');

        $this->assertEquals(0, PrivateLesson::all()->count());
    }

    /** @test  **/
    public function a_user_can_sign_up_with_this_birth_date_format()
    {
        $this->seed();

        $session = PrivatePoolSession::factory()->create([
            'private_lesson_id' => null,
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
            'stripe_token' => 'tok_visa',
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLesson::all()->count());

        $response = $this->post(route('private_lesson.store'), $data);

        $response->assertStatus(302);

        $this->assertEquals(1, PrivateLesson::all()->count());
        $this->assertEquals(1, PrivateLesson::first()->pool_sessions()->count());
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_lesson_that_has_been_taken_by_someone_else()
    {
        $this->runDatabaseMigrations();
        $this->seed();

        PrivatePoolSession::factory()->count(4)->create([
            'private_lesson_id' => null,
        ]);

        //This is the same id that was already signed up for
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
            'stripe_token' => 'tok_visa',
        ];

        $response = $this->post(route('private_lesson.store'), $data_1);

        $response->assertStatus(302);
        $response->assertRedirect(route('pages.thank-you'));

        $this->assertCount(1, PrivateSwimmer::all());

        //This is the same id that was already signed up for
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
            'stripe_token' => 'tok_visa',
        ];

        $response = $this->post(route('private_lesson.store'), $data_2);

        $response->assertStatus(302);
        $response->assertRedirect(route('private_lesson.index'));

        //Assert the user was not created
        $this->assertCount(1, PrivateSwimmer::all());
    }
}

<?php

namespace Tests\Feature;

use App\Mail\Privates\PrivateLessonSignUp;
use App\PrivatePoolSession;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PrivateLessonRequestTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_can_request_a_private_lesson()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $this->seed();

        $this->withoutExceptionHandling();

        $sessions = factory(PrivatePoolSession::class, 4)->create([
            'private_lesson_id' => null
        ]);

        $session_ids = $sessions->implode('id', ',');

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => '2018-2-1',
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => 34532,
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => $this->faker->phoneNumber,
            'pool_session_ids' => $session_ids,
            'stripe_token' => 'tok_visa'
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0,  \App\PrivateLesson::all()->count());

        $response = $this->post(route('private_lesson.store'), $data);

        $response->assertStatus(302);

        $this->assertEquals(1,  \App\PrivateLesson::all()->count());

        $this->assertDatabaseHas('private_swimmers', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "birth_date" => $data['birth_date'],
            "phone" => $data['phone'],
            'emergency_name' => $data['emergency_name'],
            'emergency_relationship' => $data['emergency_relationship'],
            'emergency_phone' => $data['emergency_phone'],
        ]);

        Mail::assertSent(PrivateLessonSignUp::class);
    }
}

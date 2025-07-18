<?php

namespace Tests\Feature;

use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function a_user_be_able_to_submit_a_contact_us()
    {
        $this->get(route('pages.contact-us'))
            ->assertSee('Contact Us');

        $this->assertCount(0, Contact::all());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->sentence(),
            'g-recaptcha-response' => '1',
        ];

        $this->post(route('contact-us.store'), $data)
            ->assertRedirect(route('pages.contact-us'));

        $this->assertCount(1, Contact::all());
        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
        ]);
    }

    #[Test]
    public function a_user_cannot_submit_a_contact_us_if_honeypot_fields_are_filled_out()
    {
        $this->get(route('pages.contact-us'))
            ->assertSee('Contact Us');

        $this->assertCount(0, Contact::all());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->sentence(),

            // honeypot fields
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'country' => $this->faker->country,
        ];

        $this->post(route('contact-us.store'), $data)
            ->assertRedirect(route('pages.contact-us'));

        $this->assertCount(0, Contact::all());
    }

    #[Test]
    public function a_user_cannot_submit_a_contact_us_where_just_one_honeypot_field_is_filled_out()
    {
        $this->get(route('pages.contact-us'))
            ->assertSee('Contact Us');

        $this->assertCount(0, Contact::all());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->sentence(),

            // honeypot field
            'first_name' => $this->faker->name,
        ];

        $this->post(route('contact-us.store'), $data)
            ->assertRedirect(route('pages.contact-us'));

        $this->assertCount(0, Contact::all());
    }

    #[Test]
    public function a_user_cannot_submit_a_contact_us_if_timestamp_is_not_within_the_last_3_seconds()
    {
        $this->get(route('pages.contact-us'))
            ->assertSee('Contact Us');

        $this->assertCount(0, Contact::all());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->sentence(),

            // honeypot fields
            'time' => Carbon::now()->timestamp,
        ];

        $this->post(route('contact-us.store'), $data)
            ->assertRedirect(route('pages.contact-us'));

        $this->assertCount(0, Contact::all());
    }

    #[Test]
    public function a_user_can_submit_a_contact_us_if_timestamp_is_within_the_last_3_seconds()
    {
        $this->get(route('pages.contact-us'))
            ->assertSee('Contact Us');

        $this->assertCount(0, Contact::all());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->sentence(),

            // honeypot fields
            'time' => Carbon::now()->timestamp - 5,
        ];

        $this->post(route('contact-us.store'), $data)
            ->assertRedirect(route('pages.contact-us'));

        $this->assertCount(1, Contact::all());
    }
}

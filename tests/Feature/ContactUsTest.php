<?php

namespace Tests\Feature;

use App\Banner;
use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test 
     * @todo write test for contact us page  **/
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
}

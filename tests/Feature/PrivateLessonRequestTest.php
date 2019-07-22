<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrivateLessonRequestTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_can_request_a_private_lesson()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'swimmer_name' => $this->faker->name,
            'email' => $this->faker->email,
            'swimmer_birth_date' => '2018-2-1',
            'phone' => $this->faker->phoneNumber,
            'type' => 'Private Lesson',
            'length' => '4 Lessons Per Month',
            'location' => 'Harrison Ranch',
            'availability' => $this->faker->paragraph,
            //'hr_resident' => 'on',
            'address' => $this->faker->address
        ];


        $this->get("/private-semi-private")
            ->assertStatus(200);

        $this->assertEquals(0,  \App\PrivateLessonLead::all()->count());

        $response = $this->json('POST', "/private-semi-private", $attributes);

        $response->assertStatus(302);

        $this->assertEquals(1,  \App\PrivateLessonLead::all()->count());

        $this->assertDatabaseHas('private_lesson_leads', [
            "swimmer_name" => $attributes['swimmer_name'],
            "email" => $attributes['email'],
            "swimmer_birth_date" => $attributes['swimmer_birth_date'],
            "phone" => $attributes['phone'],
            "type" => $attributes['type'],
            "length" => $attributes['length'],
            "location" => $attributes['location'],
            "availability" => $attributes['availability'],
            //'hr_resident' => 1,
            'address' => $attributes['address']
        ]);
    }
}

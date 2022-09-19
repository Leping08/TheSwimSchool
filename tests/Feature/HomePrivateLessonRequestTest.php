<?php

namespace Tests\Feature;

use App\PrivateLessonLead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePrivateLessonRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  **/
    public function a_user_can_sign_up_for_a_private_lesson()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'swimmer_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'swimmer_birth_date' => '2018-2-1',
            'phone' => $this->faker->phoneNumber,
            'type' => 'Private Lesson',
            'length' => '4 Lessons Per Month',
            'availability' => $this->faker->paragraph,
            'address' => $this->faker->address,
        ];

        $this->get(route('private_lesson.index'))
            ->assertStatus(200);

        $this->assertEquals(0, PrivateLessonLead::all()->count());

        $this->post(route('home_privates.store'), $attributes)
            ->assertStatus(302);

        $this->assertDatabaseHas('private_lesson_leads', [
            'swimmer_name' => $attributes['swimmer_name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'type' => $attributes['type'],
            'length' => $attributes['length'],
            'availability' => $attributes['availability'],
            'address' => $attributes['address'],
        ]);
    }
}

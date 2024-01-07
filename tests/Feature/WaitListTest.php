<?php

namespace Tests\Feature;

use App\Lesson;
use App\Mail\Admin\WaitList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WaitListTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  **/
    public function a_user_is_able_to_sign_up_for_the_wait_list_of_a_lesson_that_is_full()
    {
        Mail::fake();

        Mail::assertNothingSent();

        $lesson = Lesson::factory()->create([
            'class_size' => 0,
        ]);

        $this->assertTrue($lesson->isFull());

        $this->get(route('groups.lessons.create', ['group' => $lesson->group->type, 'lesson' => $lesson]))
            ->assertSee('This class is full.')
            ->assertSee('We recommend signing up for a different class with openings.');

        $this->assertEquals(0, $lesson->waitlist()->count());

        $attributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'date_of_birth' => $this->faker->date(),
        ];

        $this->post(route('groups.lessons.wait-list', [$lesson]), $attributes)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'date_of_birth' => $attributes['date_of_birth'],
        ]);

        Mail::assertSent(WaitList::class);
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_the_same_wait_list_twice()
    {
        $lesson = Lesson::factory()->create([
            'class_size' => 0,
        ]);

        $this->assertTrue($lesson->isFull());

        $this->get('/lessons/'.$lesson->Group->type.'/'.$lesson->id)
            ->assertSee('This class is full.')
            ->assertSee('We recommend signing up for a different class with openings.');

        $this->assertEquals(0, $lesson->waitlist()->count());

        $attributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'date_of_birth' => $this->faker->date(),
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $attributes)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'date_of_birth' => $attributes['date_of_birth'],
        ]);

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $attributes)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());
    }

    /** @test  **/
    public function a_user_can_sign_up_with_the_same_email_and_a_different_swimmer_name()
    {
        $lesson = Lesson::factory()->create([
            'class_size' => 0,
        ]);

        $this->assertTrue($lesson->isFull());

        $this->get('/lessons/'.$lesson->Group->type.'/'.$lesson->id)
            ->assertSee('This class is full.')
            ->assertSee('We recommend signing up for a different class with openings.');

        $this->assertEquals(0, $lesson->waitlist()->count());

        $swimmer = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'date_of_birth' => $this->faker->date(),
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $swimmer)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            'name' => $swimmer['name'],
            'email' => $swimmer['email'],
            'phone' => $swimmer['phone'],
            'date_of_birth' => $swimmer['date_of_birth'],
        ]);

        $swimmer2 = [
            'name' => $this->faker->name, //Different name from the first swimmer
            'email' => $swimmer['email'],
            'phone' => $swimmer['phone'],
            'date_of_birth' => $swimmer['date_of_birth'],
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $swimmer2)
            ->assertStatus(302);

        $this->assertEquals(2, $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            'name' => $swimmer2['name'],
            'email' => $swimmer2['email'],
            'phone' => $swimmer2['phone'],
            'date_of_birth' => $swimmer2['date_of_birth'],
        ]);
    }

    /** @test  **/
    public function bots_can_not_sign_up()
    {
        $lesson = Lesson::factory()->create([
            'class_size' => 0,
        ]);

        $this->assertTrue($lesson->isFull());

        $this->get('/lessons/'.$lesson->Group->type.'/'.$lesson->id)
            ->assertSee('This class is full.')
            ->assertSee('We recommend signing up for a different class with openings.');

        $this->assertEquals(0, $lesson->waitlist()->count());

        $swimmer = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '9998887777',
            'date_of_birth' => $this->faker->date(),
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $swimmer)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            'name' => $swimmer['name'],
            'email' => $swimmer['email'],
            'phone' => $swimmer['phone'],
            'date_of_birth' => $swimmer['date_of_birth'],
        ]);

        $swimmer2 = [
            'name' => $this->faker->name, //Different name from the first swimmer
            'email' => $swimmer['email'],
            'phone' => $swimmer['phone'],
            'date_of_birth' => $swimmer['date_of_birth'],

            // Honeypot fields
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip' => $this->faker->postcode
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $swimmer2)
            ->assertStatus(302);

        $this->assertEquals(1, $lesson->waitlist()->count());

        $this->assertDatabaseMissing('wait_lists', [
            'name' => $swimmer2['name'],
            'email' => $swimmer2['email'],
            'phone' => $swimmer2['phone'],
            'date_of_birth' => $swimmer2['date_of_birth'],
        ]);
    }
}

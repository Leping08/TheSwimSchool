<?php

namespace Tests\Feature;

use App\Mail\Admin\WaitList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WaitListTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_is_able_to_sign_up_for_the_wait_list_of_a_lesson_that_is_full()
    {
        Mail::fake();

        Mail::assertNothingSent();

        $lesson = factory(\App\Lesson::class)->create([
            'class_size' => 0
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
            'date_of_birth' => $this->faker->date()
        ];

        $this->post(route('groups.lessons.wait-list', [$lesson]), $attributes)
            ->assertStatus(302);

        $this->assertEquals(1,  $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            "name" => $attributes['name'],
            "email" => $attributes['email'],
            "phone" => $attributes['phone'],
            "date_of_birth" => $attributes['date_of_birth']
        ]);

        Mail::assertSent(WaitList::class);
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_the_same_wait_list_twice()
    {
        $lesson = factory(\App\Lesson::class)->create([
            'class_size' => 0
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
            'date_of_birth' => $this->faker->date()
        ];

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $attributes)
            ->assertStatus(302);

        $this->assertEquals(1,  $lesson->waitlist()->count());

        $this->assertDatabaseHas('wait_lists', [
            "name" => $attributes['name'],
            "email" => $attributes['email'],
            "phone" => $attributes['phone'],
            "date_of_birth" => $attributes['date_of_birth']
        ]);

        $this->post(route('groups.lessons.wait-list', ['lesson' => $lesson]), $attributes)
            ->assertStatus(302)
            ->dumpSession();

        $this->assertEquals(1,  $lesson->waitlist()->count());
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use App\Group;

class Lessons extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->registrationNotOpenYet = factory('App\Lesson')->create([
            'class_start_date' => Carbon::now()->addDays(3),
            'registration_open' => Carbon::now()->addDays(2),
            'class_end_date' => Carbon::now()->addDays(5)
        ]);

        $this->registrationOpen = factory('App\Lesson')->create([
            'class_start_date' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
            'class_end_date' => Carbon::now()->addDays(2)
        ]);

        $this->lessonInProgress = factory('App\Lesson')->create([
            'class_start_date' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
            'class_end_date' => Carbon::now()->addDays(2)
        ]);

        $this->lessonFinished = factory('App\Lesson')->create([
            'class_start_date' => Carbon::now()->subDays(4),
            'registration_open' => Carbon::now()->subDays(6),
            'class_end_date' => Carbon::now()->subDays(2)
        ]);
    }


    /** @test  **/
    public function a_user_can_not_see_a_lesson_in_progress()
    {
        $this->get($this->lessonInProgress->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_does_not_have_open_registration_yet()
    {
        $this->get($this->registrationNotOpenYet->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_has_finished()
    {
        $this->get($this->lessonFinished->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_see_the_groups_for_each_lesson()
    {
        $this->get('/lessons')
            ->assertSee($this->registrationOpen->Group->type)
            ->assertSee($this->registrationOpen->Group->description)
            ->assertSee($this->lessonFinished->Group->type)
            ->assertSee($this->lessonFinished->Group->description)
            ->assertSee($this->lessonInProgress->Group->type)
            ->assertSee($this->lessonInProgress->Group->description)
            ->assertSee($this->registrationNotOpenYet->Group->type)
            ->assertSee($this->registrationNotOpenYet->Group->description);
    }

    /** @test  **/
    public function a_user_can_see_the_details_of_a_lesson_that_is_open_for_registration()
    {
        $this->get($this->registrationOpen->path())
            ->assertSee($this->registrationOpen->Group->type)
            ->assertSee($this->registrationOpen->Location->name)
            ->assertSee($this->registrationOpen->Location->street)
            ->assertSee($this->registrationOpen->Location->zip)
            ->assertSee(strval($this->registrationOpen->class_size))
            ->assertSee('$'.$this->registrationOpen->price);
    }

    /** @test  **/
    public function a_user_can_sign_up_for_a_lesson_that_is_not_full()
    {
        $this->get($this->registrationOpen->path())
            ->assertSee('Sign Up');
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_lesson_that_is_full()
    {
        $this->registrationOpen->class_size = 1;
        $this->registrationOpen->update();

        $this->get($this->registrationOpen->path())
            ->assertSee('Sign Up');

        $swimmer = factory('App\Swimmer')->create();
        $swimmer->lesson_id = $this->registrationOpen->id;
        $swimmer->update();

        $this->get($this->registrationOpen->path())
            ->assertSee('Join Wait List');
    }

    /** @test  **/
    public function a_user_can_not_see_private_lesson_groups()
    {
        $lesson = factory('App\Lesson')->create();
        $group = factory('App\Group')->create();
        $lesson->update([
            'group_id' => $group->id
        ]);
        $group->update([
            'type' => 'Private LessonTest'
        ]);

        $testSet = Group::public()->get();

        $this->assertNotContains('Private LessonTest', $testSet);
    }

    /** @test  **/
    public function a_user_can_see_the_private_lesson_sign_up_page_with_a_link()
    {
        $lesson = factory('App\Lesson')->create();
        $group = factory('App\Group')->create();
        $lesson->group_id = $group->id;
        $lesson->update();
        $group->type = 'Private LessonTest';
        $group->update();

        $this->get('/lessons/'.$lesson->Group->type.'/'.$lesson->id)
            ->assertSee($lesson->Group->type)
            ->assertSee($lesson->Location->name)
            ->assertSee($lesson->Location->street)
            ->assertSee($lesson->Location->zip)
            ->assertSee(strval($lesson->class_size))
            ->assertSee('$'.$lesson->price)
            ->assertSee('Swimmer Information')
            ->assertSee('Address')
            ->assertSee('Contact Information')
            ->assertSee('Emergency Contact Information')
            ->assertSee('Checkout');
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_private_lesson_if_it_is_full()
    {
        $lesson = factory('App\Lesson')->create();
        $group = factory('App\Group')->create();
        $lesson->update([
            'group_id' => $group->id,
            'class_size' => 1
        ]);
        $group->update([
            'type' => 'Private LessonTest'
        ]);

        $swimmer = factory('App\Swimmer')->create();
        $swimmer->update([
            'lesson_id' => $lesson->id
        ]);

        $this->get('/lessons/'.$lesson->Group->type.'/'.$lesson->id)
            ->assertSee('This class is full.');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_starts_today()
    {
        $lesson = factory('App\Lesson')->create([
            'class_start_date' => Carbon::now()
        ]);

        $this->assertFalse(\App\Lesson::registrationOpen()->contains($lesson));
    }

    /** @test  **/
    public function a_swimmer_can_sign_up_by_hitting_the_lesson_sign_up_route()
    {
        $lesson = factory('App\Lesson')->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'emailUpdates' => 'off',
            'lesson_id' => $lesson->id,
            'stripeToken' => 'tok_visa'
        ];


        $this->get("/lessons/{$lesson->group->type}/{$lesson->id}")
            ->assertStatus(200);

        $this->assertEquals(0,  \App\Swimmer::all()->count());

        $response = $this->json('POST', "/lessons/{$lesson->group->type}/{$lesson->id}", $attributes);

        $response->assertRedirect('/thank-you');

        $this->assertEquals(1,  \App\Swimmer::all()->count());

        $this->assertDatabaseHas('swimmers', [
            "firstName" => $attributes['firstName'],
            "lastName" => $attributes['lastName'],
            "email" => $attributes['email'],
            "lesson_id" => $attributes['lesson_id']
        ]);
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_group_lesson_that_is_full()
    {
        $lesson = factory('App\Lesson')->create([
            'class_size' => 0
        ]);

        $swimmer = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            'emailUpdates' => 'off',
            'lesson_id' => $lesson->id,
            'stripeToken' => 'tok_visa'
        ];

        $this->assertTrue($lesson->isFull());

        $response = $this->json('POST', "/lessons/{$lesson->group->type}/{$lesson->id}", $swimmer);

        $response->assertStatus(302);
    }
}

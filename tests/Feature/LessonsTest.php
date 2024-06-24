<?php

namespace Tests\Feature;

use App\Group;
use App\Lesson;
use App\Mail\Groups\SignUp;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LessonsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  **/
    public function a_user_can_not_see_a_lesson_in_progress()
    {
        $lessonInProgress = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
            'class_end_date' => Carbon::now()->addDays(2),
        ]);

        $this->get($lessonInProgress->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_does_not_have_open_registration_yet()
    {
        $registrationNotOpenYet = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->addDays(3),
            'registration_open' => Carbon::now()->addDays(2),
            'class_end_date' => Carbon::now()->addDays(5),
        ]);

        $this->get($registrationNotOpenYet->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_has_finished()
    {
        $lessonFinished = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(4),
            'registration_open' => Carbon::now()->subDays(6),
            'class_end_date' => Carbon::now()->subDays(2),
        ]);

        $this->get($lessonFinished->path())
            ->assertSee('No Classes Available At This Time');
    }

    /** @test  **/
    public function a_user_can_see_the_groups_for_each_lesson()
    {
        $registrationOpen = Lesson::factory()->create([
            'class_start_date' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
            'class_end_date' => Carbon::now()->addDays(2),
        ]);

        $lessonFinished = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(4),
            'registration_open' => Carbon::now()->subDays(6),
            'class_end_date' => Carbon::now()->subDays(2),
        ]);

        $lessonInProgress = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
            'class_end_date' => Carbon::now()->addDays(2),
        ]);

        $registrationNotOpenYet = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->addDays(3),
            'registration_open' => Carbon::now()->addDays(2),
            'class_end_date' => Carbon::now()->addDays(5),
        ]);

        $this->get(route('groups.lessons.index'))
            ->assertSee($registrationOpen->Group->type)
            ->assertSee($registrationOpen->Group->description)
            ->assertSee($lessonFinished->Group->type)
            ->assertSee($lessonFinished->Group->description)
            ->assertSee($lessonInProgress->Group->type)
            ->assertSee($lessonInProgress->Group->description)
            ->assertSee($registrationNotOpenYet->Group->type)
            ->assertSee($registrationNotOpenYet->Group->description);
    }

    /** @test  **/
    public function a_user_can_see_the_details_of_a_lesson_that_is_open_for_registration()
    {
        $registrationOpen = Lesson::factory()->create([
            'class_start_date' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
            'class_end_date' => Carbon::now()->addDays(2),
        ]);

        $this->get($registrationOpen->path())
            ->assertSee($registrationOpen->Group->type)
            ->assertSee($registrationOpen->Location->name)
            ->assertSee($registrationOpen->Location->street)
            ->assertSee($registrationOpen->Location->zip)
            ->assertSee(strval($registrationOpen->class_size))
            ->assertSee('$'.$registrationOpen->price);
    }

    /** @test  **/
    public function a_user_can_sign_up_for_a_lesson_that_is_not_full()
    {
        $registrationOpen = Lesson::factory()->create([
            'class_start_date' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
            'class_end_date' => Carbon::now()->addDays(2),
        ]);

        $this->get($registrationOpen->path())
            ->assertSee('Sign Up');
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_lesson_that_is_full()
    {
        $registrationOpen = Lesson::factory()->create([
            'class_start_date' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
            'class_end_date' => Carbon::now()->addDays(2),
            'class_size' => 1,
        ]);

        $this->get($registrationOpen->path())
            ->assertSee('Sign Up');

        $swimmer = Swimmer::factory()->create();
        $swimmer->lesson_id = $registrationOpen->id;
        $swimmer->update();

        $this->get($registrationOpen->path())
            ->assertSee('Join Wait List');
    }

    /** @test  **/
    public function a_user_can_not_see_private_lesson_groups()
    {
        $lesson = Lesson::factory()->create();
        $group = Group::factory()->create();
        $lesson->update([
            'group_id' => $group->id,
        ]);
        $group->update([
            'type' => 'Private LessonTest',
        ]);

        $testSet = Group::public()->get();

        $this->assertNotContains('Private LessonTest', $testSet);
    }

    /** @test  **/
    public function a_user_can_see_the_private_lesson_sign_up_page_with_a_link()
    {
        $lesson = Lesson::factory()->create();
        $group = Group::factory()->create();
        $lesson->group_id = $group->id;
        $lesson->update();
        $group->type = 'Private LessonTest';
        $group->update();

        $this->get(route('groups.lessons.create', [$lesson->group, $lesson]))
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
        $lesson = Lesson::factory()->create();
        $group = Group::factory()->create();
        $lesson->update([
            'group_id' => $group->id,
            'class_size' => 1,
        ]);
        $group->update([
            'type' => 'Private LessonTest',
        ]);

        $swimmer = Swimmer::factory()->create();
        $swimmer->update([
            'lesson_id' => $lesson->id,
        ]);

        $this->get(route('groups.lessons.create', [$lesson->group, $lesson]))
            ->assertSee('This class is full.');
    }

    /** @test  **/
    public function a_user_can_not_see_a_lesson_that_starts_today()
    {
        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::now(),
        ]);

        $this->assertFalse(Lesson::registrationOpen()->get()->contains($lesson));
    }

    /** @test  **/
    public function a_swimmer_can_sign_up_by_hitting_the_lesson_sign_up_route()
    {
        $lesson = Lesson::factory()->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
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
            'stripeToken' => 'tok_visa',
        ];

        $this->get(route('groups.lessons.create', [$lesson->group, $lesson]))
            ->assertStatus(200);

        $this->assertEquals(0, Swimmer::all()->count());

        $response = $this->json('POST', "/lessons/{$lesson->group->type}/{$lesson->id}", $attributes);

        $response->assertRedirect(route('pages.thank-you'));

        $this->assertEquals(1, Swimmer::all()->count());

        $this->assertDatabaseHas('swimmers', [
            'firstName' => $attributes['firstName'],
            'lastName' => $attributes['lastName'],
            'email' => $attributes['email'],
            'lesson_id' => $attributes['lesson_id'],
        ]);
    }

    /** @test  **/
    public function a_swimmer_will_get_a_sign_up_email_after_hitting_the_lesson_sign_up_route()
    {
        Mail::fake();

        $lesson = Lesson::factory()->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
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
            'stripeToken' => 'tok_visa',
        ];

        $this->get(route('groups.lessons.create', [$lesson->group, $lesson]))
            ->assertStatus(200);

        $this->assertEquals(0, Swimmer::all()->count());

        $response = $this->json('POST', route('groups.swimmers.store', [$lesson->group, $lesson]), $attributes);

        $response->assertRedirect(route('pages.thank-you'));

        $this->assertEquals(1, Swimmer::all()->count());

        $this->assertDatabaseHas('swimmers', [
            'firstName' => $attributes['firstName'],
            'lastName' => $attributes['lastName'],
            'email' => $attributes['email'],
            'lesson_id' => $attributes['lesson_id'],
        ]);

        Mail::assertSent(SignUp::class);
    }

    /** @test  **/
    public function a_user_can_not_sign_up_for_a_group_lesson_that_is_full()
    {
        $lesson = Lesson::factory()->create([
            'class_size' => 0,
        ]);

        $swimmer = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
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
            'stripeToken' => 'tok_visa',
        ];

        $this->assertTrue($lesson->isFull());

        $response = $this->json('POST', route('groups.swimmers.store', [$lesson->group, $lesson]), $swimmer);

        $response->assertStatus(302);
    }

    /** @test  **/
    public function a_swimmer_will_see_an_error_when_trying_to_sign_up_with_a_credit_card_that_is_declined()
    {
        $lesson = Lesson::factory()->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => Carbon::yesterday()->toDateString(),
            'email' => $this->faker->email,
            'phone' => '9998887777',
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
            'stripeToken' => 'tok_chargeDeclined', //This is a declined card
        ];

        $this->get(route('groups.lessons.create', [$lesson->group, $lesson]))
            ->assertStatus(200);

        $this->assertEquals(0, Swimmer::all()->count());

        $response = $this->json('POST', route('groups.swimmers.store', [$lesson->group, $lesson]), $attributes);

        $response->assertRedirect(route('groups.lessons.create', [$lesson->group, $lesson]));

        $response->assertSessionHas('error', 'Oops, something went wrong with the payment. Your card was declined.');

        $this->assertEquals(0, Swimmer::all()->count());
    }
}

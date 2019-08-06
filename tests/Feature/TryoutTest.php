<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Mail\TryoutReminder;
use App\Library\TryoutReminderEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TryoutTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test  **/
    public function a_user_should_be_able_to_see_the_sign_up_button_if_registration_is_open()
    {
        $tryout = factory('App\Tryout')->create([
            'event_time' => Carbon::now()->addDays(2),
            'registration_open' => Carbon::now()->subDays(2),
        ]);

        $registrationOpen = \App\Tryout::registrationOpen()->get();
        $this->assertTrue($registrationOpen->contains($tryout->id));

        $this->get('/swim-team/tryouts')
            ->assertSee($tryout->class_size)
            ->assertSee($tryout->location->address)
            ->assertDontSee('Sorry No Tryouts Available At This Time');
    }

    /** @test  **/
    public function a_user_should_not_be_able_to_see_the_sign_up_button_if_registration_is_not_open()
    {
        $tryout = factory('App\Tryout')->create([
            'event_time' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
        ]);

        $registrationOpen = \App\Tryout::registrationOpen()->get();
        $this->assertFalse($registrationOpen->contains($tryout->id));

        $this->get('/swim-team/tryouts')
            ->assertSee('Sorry No Tryouts Available At This Time');
    }

    /** @test  **/
    public function a_user_should_be_able_to_sign_up_for_tryouts_if_they_have_the_sign_up_link_and_the_registration_is_not_open()
    {
        $tryout = factory('App\Tryout')->create([
            'event_time' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
        ]);

        $this->get("/swim-team/tryouts/{$tryout->id}")
            ->assertStatus(200);
    }

    /** @test  **/
    public function an_athlete_should_be_added_to_the_database_if_they_fill_out_the_tryout_sign_up_form()
    {
        $tryout = factory('App\Tryout')->create();

        $attributes = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => '999-888-7777',
            'birthDate' => Carbon::yesterday()->toDateString(),
            'parent' => $this->faker->name,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->numberBetween(10000, 90000),
            'emergencyName' => $this->faker->name,
            'emergencyRelationship' => $this->faker->word,
            'emergencyPhone' => '999-999-9999',
            //'emailUpdates' => 'off', TODO add this
            //'tryout_id' => $tryout->id,
        ];

        $this->get("/swim-team/tryouts/{$tryout->id}/")
            ->assertStatus(200);

        $this->assertEquals(0, \App\Athlete::all()->count());

        $response = $this->json('POST', "/swim-team/tryouts/{$tryout->id}", $attributes);

        $response->assertRedirect('/swim-team');

        $this->assertEquals(1, \App\Athlete::all()->count());

        $this->assertDatabaseHas('athletes', [
            'firstName' => $attributes['firstName'],
            'lastName' => $attributes['lastName'],
            'email' => $attributes['email'],
            'tryout_id' => $tryout->id,
        ]);
    }

    /** @test  **/
    public function reminder_emails_will_be_sent_out_the_day_before_the_tryout()
    {
        $tryout = factory('App\Tryout')->create([
            'event_time' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
        ]);

        $registrationOpen = \App\Tryout::registrationOpen()->get();
        $this->assertTrue($registrationOpen->contains($tryout->id));

        $athlete = factory('App\Athlete')->create([
            'tryout_id' => $tryout->id,
        ]);

        Mail::fake();
        Mail::assertNothingSent();

        (new TryoutReminderEmail)->sendReminderEmails();

        Mail::assertSent(TryoutReminder::class);
    }
}

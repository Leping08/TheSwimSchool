<?php

namespace Tests\Feature;

use App\Athlete;
use App\Library\TryoutReminderEmail;
use App\Mail\SwimTeam\TryoutReminder;
use App\Tryout;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TryoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test  **/
    public function a_user_should_be_able_to_see_the_sign_up_button_if_registration_is_open()
    {
        $tryout = Tryout::factory()->create([
            'event_time' => Carbon::now()->addDays(2),
            'registration_open' => Carbon::now()->subDays(2),
        ]);

        $registrationOpen = Tryout::registrationOpen()->get();
        $this->assertTrue($registrationOpen->contains($tryout->id));

        $this->get(route('swim-team.tryouts.index'))
            ->assertSee($tryout->class_size)
            ->assertSee($tryout->location->address)
            ->assertDontSee('Sorry No Tryouts Available At This Time');
    }

    /** @test  **/
    public function a_user_should_not_be_able_to_see_the_sign_up_button_if_registration_is_not_open()
    {
        $tryout = Tryout::factory()->create([
            'event_time' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
        ]);

        $registrationOpen = Tryout::registrationOpen()->get();
        $this->assertFalse($registrationOpen->contains($tryout->id));

        $this->get(route('swim-team.tryouts.index'))
            ->assertSee('Sorry No Tryouts Available At This Time');
    }

    /** @test  **/
    public function a_user_should_be_able_to_sign_up_for_tryouts_if_they_have_the_sign_up_link_and_the_registration_is_not_open()
    {
        $tryout = Tryout::factory()->create([
            'event_time' => Carbon::now()->subDays(2),
            'registration_open' => Carbon::now()->subDays(4),
        ]);

        $this->get(route('swim-team.tryouts.show', [$tryout]))
            ->assertStatus(200);
    }

    /** @test  **/
    public function an_athlete_should_be_added_to_the_database_if_they_fill_out_the_tryout_sign_up_form()
    {
        $tryout = Tryout::factory()->create();

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

        $this->get(route('swim-team.tryouts.show', [$tryout]))
            ->assertStatus(200);

        $this->assertEquals(0, Athlete::all()->count());

        $response = $this->post(route('swim-team.athlete.store', [$tryout]), $attributes);

        $response->assertRedirect(route('swim-team.index'));

        $this->assertEquals(1, Athlete::all()->count());

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
        $tryout = Tryout::factory()->create([
            'event_time' => Carbon::tomorrow(),
            'registration_open' => Carbon::yesterday(),
        ]);

        $registrationOpen = Tryout::registrationOpen()->get();
        $this->assertTrue($registrationOpen->contains($tryout->id));

        $athlete = Athlete::factory()->create([
            'tryout_id' => $tryout->id,
        ]);

        Mail::fake();
        Mail::assertNothingSent();

        (new TryoutReminderEmail)->sendReminderEmails();

        Mail::assertSent(TryoutReminder::class);
    }
}

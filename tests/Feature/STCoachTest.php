<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class STCoachTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test **/
    public function a_coach_will_show_up_on_the_swim_team_page_if_they_are_active()
    {
        $activeCoach = factory(\App\STCoach::class)->create([
            'active' => true
        ]);

        $notActiveCoach = factory(\App\STCoach::class)->create([
            'active' => false
        ]);

        $this->get(route('swim-team.index'))
            ->assertSee($activeCoach->name)
            ->assertDontSee($notActiveCoach->name)
            ->assertSee($activeCoach->bio)
            ->assertDontSee($notActiveCoach->bio);
    }
}

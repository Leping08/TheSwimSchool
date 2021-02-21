<?php

namespace Tests\Feature;

use App\STCoach;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class STCoachTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test **/
    public function a_coach_will_show_up_on_the_swim_team_page_if_they_are_active()
    {
        $activeCoach = STCoach::factory()->create([
            'active' => true
        ]);

        $notActiveCoach = STCoach::factory()->create([
            'active' => false
        ]);

        $this->get(route('swim-team.index'))
            ->assertSee($activeCoach->name)
            ->assertDontSee($notActiveCoach->name)
            ->assertSee($activeCoach->bio)
            ->assertDontSee($notActiveCoach->bio);
    }
}

<?php

namespace Tests\Feature;

use App\STCoach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class STCoachTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function a_coach_will_show_up_on_the_swim_team_page_if_they_are_active()
    {
        Storage::fake('s3');

        $activeCoach = STCoach::factory()->create([
            'active' => true,
        ]);

        $notActiveCoach = STCoach::factory()->create([
            'active' => false,
        ]);

        $this->get(route('swim-team.index'))
            ->assertSee($activeCoach->name)
            ->assertDontSee($notActiveCoach->name)
            ->assertSee($activeCoach->bio)
            ->assertDontSee($notActiveCoach->bio);
    }
}

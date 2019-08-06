<?php

namespace Tests\Unit;

use App\Models\STCoach;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class STCoachesTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function it_can_have_active_coaches()
    {
        factory(STCoach::class)->create([
            'active' => false,
        ]);

        $this->assertEquals(1, \App\Models\STCoach::all()->count());
        $this->assertEquals(0, \App\Models\STCoach::active()->count());

        factory(STCoach::class)->create([
            'active' => true,
        ]);

        $this->assertEquals(2, \App\Models\STCoach::all()->count());
        $this->assertEquals(1, \App\Models\STCoach::active()->count());
    }
}

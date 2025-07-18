<?php

namespace Tests\Unit;

use App\STCoach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class STCoachesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_have_active_coaches()
    {
        STCoach::factory()->create([
            'active' => false,
        ]);

        $this->assertEquals(1, STCoach::all()->count());
        $this->assertEquals(0, STCoach::active()->count());

        STCoach::factory()->create([
            'active' => true,
        ]);

        $this->assertEquals(2, STCoach::all()->count());
        $this->assertEquals(1, STCoach::active()->count());
    }
}

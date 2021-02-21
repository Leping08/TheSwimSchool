<?php

namespace Tests\Unit;

use App\Group;
use App\Lesson;
use App\Swimmer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;
    /** @test  **/
    public function it_has_many_lessons()
    {
        $group = Group::factory()->create();

        Lesson::factory()->create([
            'group_id' => $group->id
        ]);

        $this->assertInstanceOf(Lesson::class, $group->lessons()->first());
        $this->assertEquals(1, $group->lessons()->count());

        Lesson::factory()->create([
            'group_id' => $group->id
        ]);

        $this->assertEquals(2, $group->lessons()->count());
    }

    /** @test  **/
    public function it_has_public_facing_lessons()
    {
        Group::factory()->create([
            'type' => 'Star Fish'
        ]);

        $this->assertEquals(1,  Group::public()->count());

        Group::factory()->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(1,  Group::public()->count());
        $this->assertEquals(2,  Group::all()->count());
    }

    /** @test  **/
    public function it_has_private_lessons_the_public_can_not_see()
    {
        Group::factory()->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(1,  Group::private()->count());
        $this->assertEquals(0,  Group::public()->count());
        $this->assertEquals(1,  Group::all()->count());

        Group::factory()->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(2,  Group::private()->count());
        $this->assertEquals(0,  Group::public()->count());
        $this->assertEquals(2,  Group::all()->count());

        Group::factory()->create([
            'type' => 'Dolphin'
        ]);

        $this->assertEquals(2,  Group::private()->count());
        $this->assertEquals(1,  Group::public()->count());
        $this->assertEquals(3,  Group::all()->count());
    }

    /** @test  **/
    public function it_has_manny_swimmers()
    {
        $group = Group::factory()->create();

        $lesson = Lesson::factory()->create([
            'group_id' => $group->id
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id
        ]);

        $this->assertInstanceOf(Swimmer::class, $group->swimmers()->first());
        $this->assertEquals(1,  $group->swimmers()->count());

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id
        ]);

        $this->assertEquals(2,  $group->swimmers()->count());
    }
    
}

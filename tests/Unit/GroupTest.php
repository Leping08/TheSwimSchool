<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupTest extends TestCase
{
    use RefreshDatabase;
    /** @test  **/
    public function it_has_many_lessons()
    {
        $group = factory(\App\Models\Group::class)->create();

        factory(\App\Models\Lesson::class)->create([
            'group_id' => $group->id
        ]);

        $this->assertInstanceOf(\App\Models\Lesson::class, $group->lessons()->first());
        $this->assertEquals(1, $group->lessons()->count());

        factory(\App\Models\Lesson::class)->create([
            'group_id' => $group->id
        ]);

        $this->assertEquals(2, $group->lessons()->count());
    }

    /** @test  **/
    public function it_has_public_facing_lessons()
    {
        factory(\App\Models\Group::class)->create([
            'type' => 'Star Fish'
        ]);

        $this->assertEquals(1, \App\Models\Group::public()->count());

        factory(\App\Models\Group::class)->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(1, \App\Models\Group::public()->count());
        $this->assertEquals(2, \App\Models\Group::all()->count());
    }

    /** @test  **/
    public function it_has_private_lessons_the_public_can_not_see()
    {
        factory(\App\Models\Group::class)->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(1, \App\Models\Group::private()->count());
        $this->assertEquals(0, \App\Models\Group::public()->count());
        $this->assertEquals(1, \App\Models\Group::all()->count());

        factory(\App\Models\Group::class)->create([
            'type' => 'Private'
        ]);

        $this->assertEquals(2, \App\Models\Group::private()->count());
        $this->assertEquals(0, \App\Models\Group::public()->count());
        $this->assertEquals(2, \App\Models\Group::all()->count());

        factory(\App\Models\Group::class)->create([
            'type' => 'Dolphin'
        ]);

        $this->assertEquals(2, \App\Models\Group::private()->count());
        $this->assertEquals(1, \App\Models\Group::public()->count());
        $this->assertEquals(3, \App\Models\Group::all()->count());
    }

    /** @test  **/
    public function it_has_manny_swimmers()
    {
        $group = factory(\App\Models\Group::class)->create();

        $lesson = factory(\App\Models\Lesson::class)->create([
            'group_id' => $group->id
        ]);

        factory(\App\Models\Swimmer::class)->create([
            'lesson_id' => $lesson->id
        ]);

        $this->assertInstanceOf(\App\Models\Swimmer::class, $group->swimmers()->first());
        $this->assertEquals(1, $group->swimmers()->count());

        factory(\App\Models\Swimmer::class)->create([
            'lesson_id' => $lesson->id
        ]);

        $this->assertEquals(2, $group->swimmers()->count());
    }
}

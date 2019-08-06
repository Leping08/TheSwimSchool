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
        $group = factory(\App\Group::class)->create();

        factory(\App\Lesson::class)->create([
            'group_id' => $group->id,
        ]);

        $this->assertInstanceOf(\App\Lesson::class, $group->lessons()->first());
        $this->assertEquals(1, $group->lessons()->count());

        factory(\App\Lesson::class)->create([
            'group_id' => $group->id,
        ]);

        $this->assertEquals(2, $group->lessons()->count());
    }

    /** @test  **/
    public function it_has_public_facing_lessons()
    {
        factory(\App\Group::class)->create([
            'type' => 'Star Fish',
        ]);

        $this->assertEquals(1, \App\Group::public()->count());

        factory(\App\Group::class)->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(1, \App\Group::public()->count());
        $this->assertEquals(2, \App\Group::all()->count());
    }

    /** @test  **/
    public function it_has_private_lessons_the_public_can_not_see()
    {
        factory(\App\Group::class)->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(1, \App\Group::private()->count());
        $this->assertEquals(0, \App\Group::public()->count());
        $this->assertEquals(1, \App\Group::all()->count());

        factory(\App\Group::class)->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(2, \App\Group::private()->count());
        $this->assertEquals(0, \App\Group::public()->count());
        $this->assertEquals(2, \App\Group::all()->count());

        factory(\App\Group::class)->create([
            'type' => 'Dolphin',
        ]);

        $this->assertEquals(2, \App\Group::private()->count());
        $this->assertEquals(1, \App\Group::public()->count());
        $this->assertEquals(3, \App\Group::all()->count());
    }

    /** @test  **/
    public function it_has_manny_swimmers()
    {
        $group = factory(\App\Group::class)->create();

        $lesson = factory(\App\Lesson::class)->create([
            'group_id' => $group->id,
        ]);

        factory(\App\Swimmer::class)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertInstanceOf(\App\Swimmer::class, $group->swimmers()->first());
        $this->assertEquals(1, $group->swimmers()->count());

        factory(\App\Swimmer::class)->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(2, $group->swimmers()->count());
    }
}

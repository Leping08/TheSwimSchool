<?php

namespace Tests\Unit;

use App\Group;
use App\Lesson;
use App\Skill;
use App\Swimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_has_many_lessons()
    {
        $group = Group::factory()->create();

        Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        $this->assertInstanceOf(Lesson::class, $group->lessons()->first());
        $this->assertEquals(1, $group->lessons()->count());

        Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        $this->assertEquals(2, $group->lessons()->count());
    }

    #[Test]
    public function it_has_public_facing_lessons()
    {
        Group::factory()->create([
            'type' => 'Star Fish',
        ]);

        $this->assertEquals(1, Group::public()->count());

        Group::factory()->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(1, Group::public()->count());
        $this->assertEquals(2, Group::all()->count());
    }

    #[Test]
    public function shark_is_a_private_lesson()
    {
        Group::factory()->create([
            'type' => 'Star Fish',
        ]);

        $this->assertEquals(1, Group::public()->count());

        Group::factory()->create([
            'type' => 'Shark Level (Youth Advanced - Swim Club)',
        ]);

        $this->assertEquals(1, Group::public()->count());
        $this->assertEquals(2, Group::all()->count());
    }

    #[Test]
    public function it_has_private_lessons_the_public_can_not_see()
    {
        Group::factory()->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(1, Group::private()->count());
        $this->assertEquals(0, Group::public()->count());
        $this->assertEquals(1, Group::all()->count());

        Group::factory()->create([
            'type' => 'Private',
        ]);

        $this->assertEquals(2, Group::private()->count());
        $this->assertEquals(0, Group::public()->count());
        $this->assertEquals(2, Group::all()->count());

        Group::factory()->create([
            'type' => 'Dolphin',
        ]);

        $this->assertEquals(2, Group::private()->count());
        $this->assertEquals(1, Group::public()->count());
        $this->assertEquals(3, Group::all()->count());
    }

    #[Test]
    public function it_has_manny_swimmers()
    {
        $group = Group::factory()->create();

        $lesson = Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertInstanceOf(Swimmer::class, $group->swimmers()->first());
        $this->assertEquals(1, $group->swimmers()->count());

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(2, $group->swimmers()->count());
    }

    #[Test]
    public function it_has_manny_skills()
    {
        $group = Group::factory()->create();

        $lesson = Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        $swimmer = Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $skill = Skill::factory()->create([
            'group_id' => $group->id,
        ]);

        $this->assertInstanceOf(Skill::class, $group->skills()->first());

        $this->assertEquals(1, $group->skills()->count());
    }

    #[Test]
    public function it_belongs_to_a_next_level()
    {
        $group = Group::factory()->create();

        $nextLevel = Group::factory()->create();

        $group->update([
            'next_level_id' => $nextLevel->id,
        ]);

        $this->assertInstanceOf(Group::class, $group->nextLevel);
        $this->assertEquals($nextLevel->id, $group->nextLevel->id);
    }
}

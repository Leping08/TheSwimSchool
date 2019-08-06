<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function it_can_have_enough_swimmers_that_makes_it_full()
    {
        $lesson = factory('App\Lesson')->create([
            'class_size' => 2,
        ]);

        $this->assertEquals(false, $lesson->isFull());

        factory('App\Swimmer')->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(false, $lesson->isFull());

        factory('App\Swimmer')->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(true, $lesson->isFull());
    }

    /** @test  **/
    public function it_has_swimmers()
    {
        $lesson = factory('App\Lesson')->create();

        $this->assertEquals(false, $lesson->hasSwimmers());

        factory('App\Swimmer')->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals(true, $lesson->hasSwimmers());
    }

    /** @test  **/
    public function it_can_be_private()
    {
        $group = factory('App\Group')->create([
            'type' => 'Star Fish',
        ]);

        $lesson = factory('App\Lesson')->create([
            'group_id' => $group->id,
        ]);

        $this->assertEquals(false, $lesson->isPrivate());

        $group->update([
            'type' => 'Private',
        ]);

        $lesson = $lesson->fresh();

        $this->assertEquals(true, $lesson->isPrivate());
    }
}

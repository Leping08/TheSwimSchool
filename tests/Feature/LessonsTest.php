<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LessonsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  **/
    public function a_user_can_see_the_details_of_a_lesson()
    {
        $lesson = factory('App\Lesson')->create();
        $this->get($lesson->path())
            ->assertSee($lesson->Group->type)
            ->assertSee($lesson->Location->name)
            ->assertSee($lesson->Location->street)
            ->assertSee($lesson->Location->zip);
    }
}

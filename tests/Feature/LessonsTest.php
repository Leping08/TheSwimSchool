<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LessonsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->lesson = factory('App\Lesson')->create();
    }

    /** @test  **/
    public function a_user_can_see_the_details_of_a_lesson()
    {
        $this->get($this->lesson->path())
            ->assertSee($this->lesson->Group->type)
            ->assertSee($this->lesson->Location->name)
            ->assertSee($this->lesson->Location->street)
            ->assertSee($this->lesson->Location->zip);
    }
}

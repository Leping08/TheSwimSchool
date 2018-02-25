<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function a_user_can_see_groups()
    {
        $group = factory('App\Group')->create();
        $response = $this->get('/lessons');
        $response->assertSee($group->type);
        $response->assertSee($group->description);
        $response->assertSee($group->ages);
    }
}

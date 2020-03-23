<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  **/
    public function a_user_should_see_a_banner_if_its_active()
    {
        $banner = factory(\App\Banner::class)->create([
            'page' => '/swim-team',
            'active' => false,
            'text' => 'This is the banner'
        ]);

        $this->get(route('swim-team.index'))
            ->assertDontSee($banner->text)
            ->assertSee('Swim Team');

        $banner->active = true;
        $banner->save();

        $this->get(route('swim-team.index'))
            ->assertSee($banner->text)
            ->assertSee('Swim Team');
    }
}

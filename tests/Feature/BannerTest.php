<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BannerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  **/
    public function a_user_should_see_a_banner_if_its_active()
    {
        $banner = factory(\App\Models\Banner::class)->create([
            'page' => '/swim-team',
            'active' => false,
            'text' => 'This is the banner',
        ]);

        $this->get('/swim-team')
            ->assertDontSee($banner->text)
            ->assertSee('Swim Team');

        $banner->active = true;
        $banner->save();

        $this->get('/swim-team')
            ->assertSee($banner->text)
            ->assertSee('Swim Team');
    }
}

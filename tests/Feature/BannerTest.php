<?php

namespace Tests\Feature;

use App\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BannerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_should_see_a_banner_if_its_active()
    {
        Storage::fake('s3');

        $banner = Banner::factory()->create([
            'page' => '/swim-team',
            'active' => false,
            'text' => 'This is the banner',
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

<?php

namespace Tests\Feature;

use App\Lesson;
use App\Swimmer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_non_admin_can_not_see_swimmers_in_a_lesson()
    {
        $swimmer = Swimmer::factory()->create();
        $lesson = Lesson::first();

        $this->get(route('groups.lessons.show', ['group' => $lesson->group]))
            ->assertDontSee($swimmer->firstName)
            ->assertDontSee($swimmer->lastName);
    }

    #[Test]
    public function an_allowlisted_admin_email_can_view_nova()
    {
        $user = User::factory()->create(['email' => 'mollyehrhardt@gmail.com']);

        $this->assertTrue(Gate::forUser($user)->allows('viewNova'));
    }

    #[Test]
    public function a_removed_admin_email_can_not_view_nova()
    {
        $user = User::factory()->create(['email' => 'jmlombard24@gmail.com']);

        $this->assertFalse(Gate::forUser($user)->allows('viewNova'));
    }

    #[Test]
    public function a_non_allowlisted_email_can_not_view_nova()
    {
        $user = User::factory()->create();

        $this->assertFalse(Gate::forUser($user)->allows('viewNova'));
    }
}

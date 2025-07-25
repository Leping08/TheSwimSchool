<?php

namespace Tests\Feature;

use App\Lesson;
use App\Swimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupCertificateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_should_see_swimmer_certificate()
    {
        $lesson = Lesson::factory()->create();
        $swimmer = Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->get(route('groups.certificate.show', ['encrypted_swimmer_id' => $swimmer->encryptedId]))
            ->assertStatus(200)
            ->assertSee($swimmer->firstName)
            ->assertSee($swimmer->lastName)
            ->assertSee($swimmer->lesson->instructor->name)
            ->assertSee($swimmer->lesson->class_end_date->format('m/d/y'))
            ->assertSee($swimmer->lesson->group->icon_path);
    }

    #[Test]
    public function a_user_get_an_error_with_a_bad_string_for_a_user_id()
    {
        $this->get(route('groups.certificate.show', ['encrypted_swimmer_id' => 'wrong_id']))
            ->assertStatus(400)
            ->assertSee('Invalid encrypted swimmer');
    }

    #[Test]
    public function a_user_get_an_error_with_the_wrong_swimmer_id()
    {
        $encrypted_id = Crypt::encryptString('5');
        $this->get(route('groups.certificate.show', ['encrypted_swimmer_id' => $encrypted_id]))
            ->assertStatus(404)
            ->assertSee('Swimmer not found');
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupScheduleTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function schedule_page_no_longer_exists(): void
    {
        $this->assertFalse(app('router')->has('groups.schedule.index'));
    }

    #[Test]
    public function lessons_page_shows_the_download_button(): void
    {
        Storage::fake('s3');

        $response = $this->get(route('groups.lessons.index'));

        $response->assertStatus(200);
        $response->assertSee('Group_Lesson_Schedule.pdf');
        $response->assertSee('Download Schedule');
    }

    #[Test]
    public function guest_cannot_upload_group_schedule_pdf(): void
    {
        $response = $this->post(route('groups.schedule.upload'), []);

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_upload_group_schedule_pdf(): void
    {
        Storage::fake('s3');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('Group_Lesson_Schedule.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post(route('groups.schedule.upload'), [
            'group_schedule_pdf' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue(Storage::disk('s3')->exists('pdf/Group_Lesson_Schedule.pdf'));
    }

    #[Test]
    public function upload_requires_a_pdf_file(): void
    {
        Storage::fake('s3');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('groups.schedule.upload'), [
            'group_schedule_pdf' => UploadedFile::fake()->create('schedule.txt', 100, 'text/plain'),
        ]);

        $response->assertSessionHasErrors('group_schedule_pdf');
        $this->assertFalse(Storage::disk('s3')->exists('pdf/Group_Lesson_Schedule.pdf'));
    }
}

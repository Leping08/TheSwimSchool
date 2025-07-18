<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\User;
use PHPUnit\Framework\Attributes\Test;

class SwimTeamRecordsUploadTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_guest_cannot_upload_records_pdf()
    {
        $response = $this->post('/swim-team/records/upload', []);
        $response->assertRedirect('/login');
    }

    #[Test]
    public function test_authenticated_user_can_upload_records_pdf()
    {
        Storage::fake('s3');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('PBS_Team_Records.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post('/swim-team/records/upload', [
            'records_pdf' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue(Storage::disk('s3')->exists('pdf/PBS_Team_Records.pdf'));
    }

    #[Test]
    public function test_upload_requires_pdf_file()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('not_a_pdf.txt', 10, 'text/plain');

        $response = $this->actingAs($user)->post('/swim-team/records/upload', [
            'records_pdf' => $file,
        ]);

        $response->assertSessionHasErrors('records_pdf');
    }
}

<?php

namespace Tests\Unit;

use App\Jobs\SendLessonCompletedEmail;
use App\Mail\Groups\SendCertificate;
use App\Nova\Actions\CompleteProgressReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Laravel\Nova\Fields\ActionFields;
use Tests\TestCase;

class ProgressReportActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_should_save_the_skills_that_are_checked()
    {
        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        // Assert that the progress report was created with the correct values
        $swimmer->progressReports->each(function ($progressReport) {
            $this->assertTrue($progressReport->passed);
        });
    }

    /** @test */
    public function is_should_update_the_skills_if_the_action_is_run_twice()
    {
        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        // Assert that the progress report was created with the correct values
        $swimmer->progressReports->each(function ($progressReport) {
            $this->assertTrue($progressReport->passed);
        });

        // Run the action again with different values
        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => false];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        $swimmer = $swimmer->fresh();

        // Assert that the progress report was created with the correct values
        $swimmer->progressReports->each(function ($progressReport) {
            $this->assertFalse($progressReport->passed);
        });
    }

    /** @test */
    public function is_should_queue_the_email_when_the_complete_progress_report_action_is_run()
    {
        Mail::fake();
        Queue::fake();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        // Assert that the progress report was created with the correct values
        $swimmer->progressReports->each(function ($progressReport) {
            $this->assertTrue($progressReport->passed);
        });

        // Run the action again with different values
        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => false];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'graduated' => true,
            'swimmer_id' => $swimmer->id,
        ]);

        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        // Assert the SendLessonCompletedEmail job was dispatched
        Queue::assertPushed(SendLessonCompletedEmail::class);
    }

    /** @test */
    public function is_should_email_the_swimmer_the_list_of_skills_they_passed()
    {
        Mail::fake();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the email was sent to the correct email address
        Mail::assertSent(SendCertificate::class, function ($mail) use ($swimmer) {
            return $mail->hasTo($swimmer->email);
        });

        // Manually send the SendCertificate email
        $mailable = new SendCertificate($swimmer->lesson, $swimmer, $pdf = '');

        // Get one of the skills the swimmer passed
        $swimmer->progressReports->each(function ($progressReport) use ($mailable) {
            $mailable->assertSeeInHtml($progressReport->skill->description);
        });
    }

    /** @test */
    public function if_the_pdf_exists_it_gets_attatched_to_the_email()
    {
        Mail::fake();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the email was sent to the correct email address
        Mail::assertSent(SendCertificate::class, function ($mail) use ($swimmer) {
            return $mail->hasTo($swimmer->email);
        });

        $pdf = 'this_is_a_fake_pdf';

        // Manually send the SendCertificate email
        $mailable = new SendCertificate($swimmer->lesson, $swimmer, $pdf);

        $mailable->assertHasAttachedData($pdf, 'certificate.pdf', ['mime' => 'application/pdf']);
    }

    /** @test */
    public function it_should_not_attatch_the_certificate_if_the_swimmer_does_not_graduate()
    {
        Mail::fake();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        // Assert the email was sent to the correct email address
        Mail::assertSent(SendCertificate::class, function ($mail) use ($swimmer) {
            return $mail->hasTo($swimmer->email);
        });

        $pdf = '';

        // Manually send the SendCertificate email
        $mailable = new SendCertificate($swimmer->lesson, $swimmer, $pdf);

        // Assert the email does not have the certificate attached
        $this->assertEmpty($mailable->attachments);
    }

    /** @test */
    public function it_will_delete_any_skills_that_are_not_assigned_to_the_swimmer_level()
    {
        Mail::fake();

        $group = \App\Group::factory()->create();
        $skills = \App\Skill::factory()->count(3)->create([
            'group_id' => $group->id,
        ]);
        $lesson = \App\Lesson::factory()->create([
            'group_id' => $group->id,
        ]);

        $group_2 = \App\Group::factory()->create();
        $skill_2 = \App\Skill::factory()->create([
            'group_id' => $group_2->id,
        ]);

        $swimmer = \App\Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $swimmer->progressReports()->create([
            'skill_id' => $skill_2->id,
            'passed' => true,
        ]);

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => false];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'swimmer_id' => $swimmer->id,
        ]);

        $progressReport = new CompleteProgressReport();
        $action = new ActionFields($fields, collect());
        $progressReport->handle($action, collect([$swimmer]));

        $swimmer = $swimmer->fresh();

        // Assert the progress report was created for every skill
        $this->assertCount($skills->count(), $swimmer->progressReports);

        // Assert that the progress report was created with the correct values
        $swimmer->progressReports->each(function ($progressReport) {
            $this->assertFalse($progressReport->passed);
        });

        // Assert the skill that was not in the group was deleted
        $this->assertEmpty($swimmer->progressReports->where('skill_id', $skill_2->id));
    }
}

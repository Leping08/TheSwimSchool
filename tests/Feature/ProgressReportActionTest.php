<?php

namespace Tests\Unit;

use App\Nova\Actions\CompleteProgressReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Nova\Fields\ActionFields;
use Tests\TestCase;

class ProgressReportActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_should_save_the_skills_that_are_checked()
    {
        $this->seed();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'gruadated' => false,
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
        $this->seed();

        $group = \App\Group::factory()->create();
        $swimmer = \App\Swimmer::factory()->create();
        $skills = $group->skills;

        $defaultValues = $skills->mapWithKeys(function ($skill) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            return [$skill->id => true];
        });

        $fields = collect([
            'skills' => $defaultValues,
            'gruadated' => false,
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
            'gruadated' => false,
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
}

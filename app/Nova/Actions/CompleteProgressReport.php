<?php

namespace App\Nova\Actions;

use App\ProgressReport;
use App\Swimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Http\Requests\NovaRequest;

class CompleteProgressReport extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();

        collect($fields->skills)->map(function ($value, $key) use ($model) {
            ProgressReport::updateOrCreate([
                'swimmer_id' => $model->id,
                'skill_id' => $key,
            ], [
                'swimmer_id' => $model->id,
                'skill_id' => $key,
                'passed' => $value,
            ]);
        });

        return Action::message('Progress report updated!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $swimmer = Swimmer::find($request->resourceId ?? $request->resources);

        $swimmer->load('lesson.group.skills', 'progressReports');
        $skills = $swimmer->lesson->group->skills;
        $progressReports = $swimmer->progressReports;

        $options = $skills->pluck('description', 'id');
        $defaultValues = $skills->mapWithKeys(function ($skill) use ($progressReports) {
            // Sync the existing progress report if it exists with the already selected values if they exist
            $existingValue = $progressReports->where('skill_id', $skill->id)->first()?->passed;

            return [$skill->id => $existingValue ?? true];
        });

        return [
            // @todo send out the report card PDF
            // @todo wire up the send gruadation certificate PDF if they graduated
            Boolean::make('Gruadated'),
            BooleanGroup::make('Skills')
                ->options($options)
                ->withMeta(['value' => $defaultValues]),
        ];
    }
}

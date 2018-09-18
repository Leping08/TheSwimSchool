<?php

namespace App\Nova\Metrics;

use App\Lesson;
use App\Season;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class LessonsPerSeason extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Lesson::class, 'season_id')
            ->label(function ($value){
                $season = Season::find($value);
                return "$season->year $season->season";
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'lessons-per-season';
    }
}
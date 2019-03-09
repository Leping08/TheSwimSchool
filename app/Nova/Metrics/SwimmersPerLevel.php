<?php

namespace App\Nova\Metrics;

use App\Models\Group;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class SwimmersPerLevel extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
//        $groups = Group::withCount('swimmers')->get();
//        $result = $groups->mapWithKeys(function ($item) {
//            return [$item['type'] => $item['swimmers_count']];
//        })->toArray();

        return $this->result([
            "Parent and Infant-Toddler Level I" => 62,
            "Parent and Toddler Level II" => 39,
            "Shrimp Level (Preschool Beginner)" => 99,
            "Seahorse Level (Preschool Intermediate)" => 78,
            "Starfish Level (Preschool Advanced)" => 61,
            "Stingray Level (Youth Beginner)" => 31,
            "Dolphin Level (Youth Intermediate)" => 66,
            "Flying Fish Level (Youth Advanced - Swim Club)" => 5,
            "Private" => 106,
            "Semi-Private" => 64
        ]);
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
        return 'swimmers-per-level';
    }
}

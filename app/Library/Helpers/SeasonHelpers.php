<?php

namespace App\Library\Helpers;

use App\Season;
use Carbon\Carbon;

class SeasonHelpers
{
    /**
     * @return mixed
     */
    public static function currentSeason()
    {
        //TODO Get this to work in the first 2 months of the year when it is winter for last year
        $now = Carbon::now();

        return Season::where('year', '=', $now->year)
            ->where('season', '=', SeasonHelpers::getSeasonString($now->month))
            ->first();
    }

    /**
     * @param $date
     * @return mixed
     */
    public static function seasonFromDate($date)
    {
        $carbonDate = Carbon::parse($date);

        return Season::where('year', '=', $carbonDate->year)
            ->where('season', '=', SeasonHelpers::getSeasonString($carbonDate->month))
            ->first();
    }

    /**
     * @param  int  $currentMonth
     * @return string
     */
    public static function getSeasonString(int $currentMonth)
    {
        //retrieve season
        if ($currentMonth >= 3 && $currentMonth <= 5) {
            return 'Spring';
        } elseif ($currentMonth >= 6 && $currentMonth <= 8) {
            return 'Summer';
        } elseif ($currentMonth >= 9 && $currentMonth <= 11) {
            return 'Fall';
        } else {
            return 'Winter';
        }
    }
}

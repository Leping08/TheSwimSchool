<?php

namespace App\Library\Helpers;

use Carbon\Carbon;
use App\Season;

class SeasonHelpers
{
    /**
     * @return mixed
     */
    public static function currentSeason()
    {
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
     * @param int $currentMonth
     * @return string
     */
    public static function getSeasonString(int $currentMonth)
    {
        //retrieve season
        if ($currentMonth>=3 && $currentMonth<=5){
            return "Spring";
        }
        elseif ($currentMonth>=6 && $currentMonth<=8){
            return "Summer";
        }
        elseif ($currentMonth>=9 && $currentMonth<=11){
            return "Fall";
        }
        else{
            return "Winter";
        }
    }
}
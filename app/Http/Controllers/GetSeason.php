<?php
/**
 * Created by PhpStorm.
 * User: Leping-Gaming
 * Date: 10/29/2017
 * Time: 3:23 PM
 */

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Season;

class GetSeason
{
    public static function getCurrentSeason()
    {
        $now = Carbon::now();
        $season = Season::where('year', '=', $now->year)
            ->where('season', '=', GetSeason::getSeasonString($now->month))
            ->get();
        return $season[0];
    }

    public static function getSeasonFromDate($date)
    {
        $carbonDate = Carbon::parse($date);
        $season = Season::where('year', '=', $carbonDate->year)
            ->where('season', '=', GetSeason::getSeasonString($carbonDate->month))
            ->get();
        return $season[0];
    }

    public static function getSeasonString($currentMonth)
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
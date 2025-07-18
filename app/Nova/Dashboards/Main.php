<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\LessonsPerLevel;
use App\Nova\Metrics\LessonsPerSeason;
use App\Nova\Metrics\NewEmailList;
use App\Nova\Metrics\NewLessons;
use App\Nova\Metrics\NewSwimmers;
use App\Nova\Metrics\SubscribedEmails;
use App\Nova\Metrics\SwimmersPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            SwimmersPerDay::make()->width('2/3'),
            NewSwimmers::make()->width('1/3'),
            NewLessons::make()->width('1/3'),
            LessonsPerLevel::make()->width('2/3'),
            LessonsPerSeason::make()->width('2/3'),
            NewEmailList::make()->width('1/3'),
            SubscribedEmails::make()->width('full'),
            Help::make()->width('full'),
        ];
    }
}

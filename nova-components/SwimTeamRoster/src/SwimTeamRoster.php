<?php

namespace Leping\SwimTeamRoster;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class SwimTeamRoster extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        // Nova::script('swim-team-roster', __DIR__.'/../dist/js/tool.js');
        // Nova::style('swim-team-roster', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuItem::externalLink('Roster', '/roster');
    }
}

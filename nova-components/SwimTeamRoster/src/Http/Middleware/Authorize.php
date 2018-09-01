<?php

namespace Derk\SwimTeamRoster\Http\Middleware;

use Derk\SwimTeamRoster\SwimTeamRoster;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(SwimTeamRoster::class)->authorize($request) ? $next($request) : abort(403);
    }
}

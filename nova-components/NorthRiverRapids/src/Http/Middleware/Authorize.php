<?php

namespace Leping\NorthRiverRapids\Http\Middleware;

use Leping\NorthRiverRapids\NorthRiverRapids;

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
        return resolve(NorthRiverRapids::class)->authorize($request) ? $next($request) : abort(403);
    }
}

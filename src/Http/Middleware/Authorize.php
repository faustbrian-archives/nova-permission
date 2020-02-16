<?php

namespace KodeKeep\NovaPermission\Http\Middleware;

use KodeKeep\NovaPermission\NovaPermission;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaPermission::class)->authorize($request) ? $next($request) : abort(403);
    }
}

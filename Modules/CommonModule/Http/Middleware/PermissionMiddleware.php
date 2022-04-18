<?php

namespace Modules\CommonModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $me = auth(getCurrentGuard())->user();

        abort_if(!($me->hasPermissions($permissions)), 403);

        return $next($request);
    }
}

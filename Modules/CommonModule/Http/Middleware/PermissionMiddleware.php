<?php

namespace Modules\CommonModule\Http\Middleware;

use App\Proxy\InternalRequest;
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

        if (!$me->hasPermissions($permissions)) {
            if (!($request instanceof InternalRequest)) {
                abort(403);
            }
        }

        return $next($request);
    }
}

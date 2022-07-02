<?php

namespace Modules\CommonModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $me = auth(getCurrentGuard())->user();

        abort_if(!(optional($me->vendor)->type === $type), 403);

        return $next($request);
    }
}

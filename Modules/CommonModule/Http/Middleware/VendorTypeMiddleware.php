<?php

namespace Modules\CommonModule\Http\Middleware;

use App\Proxy\InternalRequest;
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

        if (optional($me->vendor)->type !== $type) {
            if (!($request instanceof InternalRequest)) {
                abort(403);
            }
        }

        return $next($request);
    }
}

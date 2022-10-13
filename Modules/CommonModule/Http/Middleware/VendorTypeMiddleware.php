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
        $vendorTypes = is_array($me->vendor->type) ? $me->vendor->type : [$me->vendor->type];

        if (!in_array($type, $vendorTypes)) {
            if (!($request instanceof InternalRequest)) {
                abort(403);
            }
        }

        return $next($request);
    }
}

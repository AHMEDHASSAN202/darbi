<?php

namespace Modules\CommonModule\Http\Middleware;

use App\Proxy\InternalRequest;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ActiveVendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $me = auth(getCurrentGuard())->user();

        if (optional($me->vendor)->isNotActive()) {
            if (!($request instanceof InternalRequest)) {
                $tokenPayload = @JWTAuth::setToken($request->bearerToken())->getPayload()->toArray();
                if (arrayGet($tokenPayload, 'super_admin_login_as_vendor') !== true) {
                    abort(403);
                }
            }
        }

        return $next($request);
    }
}

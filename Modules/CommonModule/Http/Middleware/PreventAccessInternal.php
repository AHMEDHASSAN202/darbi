<?php

namespace Modules\CommonModule\Http\Middleware;

use App\Proxy\InternalRequest;
use Closure;
use Illuminate\Http\Request;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PreventAccessInternal
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('commonmodule.preventAccessInternal', true)) {
            if (!($request instanceof InternalRequest)) {
                return $this->apiResponse([], 403);
            }
        }

        return $next($request);
    }
}

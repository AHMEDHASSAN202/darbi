<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (\Throwable $e, $request) {
            if ($request->is('api*')) {
                if ($e instanceof HttpException) {
                    return $this->apiResponse([], $e->getStatusCode());
                }elseif ($e instanceof ValidationException) {
                    return $this->apiResponse([], 422, null, getFirstError($e->errors()));
                }elseif ($e instanceof AuthenticationException) {
                    return $this->apiResponse([], 401, 'Unauthenticated.');
                }else {
                    return $this->apiResponse([], 500, app()->environment('local') ? $e->getMessage() : null);
                }
            }
        });
    }
}

<?php

namespace Modules\CommonModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocalizationMiddleware
{
    private $defaultLanguage = 'en';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $language = $request->header('x-language');

        if (!$language) {
            $language = $request->query('lang');
        }

        if (!$language || !in_array($language, $this->getLanguagesCode())) {
            $language = $this->getDefaultLanguage();
        }

        app()->setLocale($language);

        return $next($request);
    }

    private function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    private function getLanguagesCode()
    {
        return [
            'ar', 'en'
        ];
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $supportedLanguages = config('constants.LANGUAGES');
        $fallbackLanguage = config('constants.FALLBACK_LANGUAGE');
        $lang = $request->header('X-Lang') ?? $fallbackLanguage;
        if (!in_array($lang, $supportedLanguages)) {
            $lang = $fallbackLanguage;
        }
        app()->setLocale($lang);
        return $next($request);
    }
}

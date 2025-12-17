<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => __('auth/validation.user_not_found')], 404);
            } else {
                Auth::guard('api')->setUser($user);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => __('auth/validation.not_valid_token')], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $token = JWTAuth::getToken();
                $newToken = JWTAuth::refresh($token);

                return $next($request)->header('X-Refresh-Token', $newToken);
            } else {
                return response()->json(['error' => __('auth/validation.token_not_found')], 401);
            }
        }

        return $next($request);
    }
}

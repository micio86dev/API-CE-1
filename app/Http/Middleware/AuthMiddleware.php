<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
                $request->merge(['loggedUser' => $user]);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => __('auth/validation.not_valid_token')], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => __('auth/validation.expired_token')], 401);
            } else {
                return response()->json(['error' => __('auth/validation.token_not_found')], 401);
            }
        }

        return $next($request);
    }
}
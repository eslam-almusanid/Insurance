<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $ability): Response
    {
        // Check if user is authenticated as admin
        if (!Auth::guard('user')->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Get the current token
        $token = $request->user()->currentAccessToken();

        // Check if token has super-admin ability
        if (!in_array($ability, $token->abilities ?? [])) {
            return response()->json(['message' => 'Unauthorized. '.$ability.' permission required.'], 403);
        }

        return $next($request);
    }
}

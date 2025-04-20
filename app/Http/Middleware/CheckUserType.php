<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        if (auth()->guard('api_account')->check()) {
            $user = auth()->guard('api_account')->user();
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Set the authenticated user instance manually
        Auth::setUser($user);

        $allowedTypes = explode(',', implode(',', $types));

        if (!in_array($user->account_type, $allowedTypes)) {
            return response()->json(['error' => 'Forbidden: Invalid account type'], 403);
        }
        return $next($request);
    }
}
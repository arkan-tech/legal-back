<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('api_account')->check()) {
            $user = Auth::guard('api_account')->user();

            // Check if the authenticated user is a Lawyer or ServiceUser
            if ($user instanceof Account) {
                $user->update(['last_seen' => now()]);
            }
        }

        return $next($request);
    }
}

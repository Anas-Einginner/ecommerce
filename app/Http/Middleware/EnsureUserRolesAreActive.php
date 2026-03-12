<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRolesAreActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        // لو أي role للمستخدم inactive → امنعيه
        $hasInactiveRole = $user->roles()
            ->where('status', 'inactive')
            ->exists();

        if ($hasInactiveRole) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'دورك غير مفعّل، تواصل مع الإدارة'
                ]);
        }

        return $next($request);
    }
}

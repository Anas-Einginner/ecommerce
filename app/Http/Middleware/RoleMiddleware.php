<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = auth()->user();
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $roles = $user->roles; // collection

        if ($roles->isNotEmpty() && $roles->contains(fn ($r) => ($r->status ?? 'active') !== 'active')) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'الدور الخاص بك معطّل، تواصل مع الإدارة']);
        }
        // إذا المستخدم customer → ممنوع
        if (auth()->user()->hasRole('customer')) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'auth' => 'غير مصرح لك بالدخول'
                ]);
        }

        // أي role غير customer مسموح
        return $next($request);
    }
}

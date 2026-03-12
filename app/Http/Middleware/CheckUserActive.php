<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::check() && Auth::user()->status !== 'active') {
        //     Auth::logout();

        //     return redirect()->route('login')->withErrors([
        //         'email' => 'Your account is not activated. Please contact the administration.',
        //     ]);
        // }
        // if (Auth::check() && strtolower(Auth::user()->status) !== 'active') {
        //     Auth::logout();

        //     return redirect()->route('login')->with('inactive_account', true); 
        // }
        // return $next($request);
    if (Auth::check()) {

        if (strtolower(Auth::user()->status) !== 'active') {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('inactive_account', true);
        }
    }

    return $next($request);
        }
}

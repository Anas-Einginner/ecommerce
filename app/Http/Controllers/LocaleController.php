<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    //

        /**
     * Handle language switch.
     */
    public function __invoke(Request $request, string $locale)
    {
        abort_unless(in_array($locale, ['ar', 'en']), 404);

        session(['locale' => $locale]);
        App::setLocale($locale);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return redirect()->back();
    }
}

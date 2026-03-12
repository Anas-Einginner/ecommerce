<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
    $settings = PaymentSetting::whereIn('key', [
        'stripe_public_key',
        'stripe_secret_key'
    ])->pluck('value', 'key');

    return view('dashboard.stripe.stripe', [
        'publicKey' => $settings['stripe_public_key'] ?? '',
        'secretKey' => $settings['stripe_secret_key'] ?? ''
    ]);
    }

   public function store(Request $request)
{
    $request->validate([
        'stripe_public_key' => 'required',
        'stripe_secret_key' => 'nullable',
    ]);

    PaymentSetting::updateOrCreate(
        ['key' => 'stripe_public_key'],
        ['value' => $request->stripe_public_key]
    );

    if ($request->filled('stripe_secret_key')) {
        PaymentSetting::updateOrCreate(
            ['key' => 'stripe_secret_key'],
            ['value' => $request->stripe_secret_key]
        );
    }

    return back()->with('success', 'تم تحديث مفاتيح Stripe بنجاح');
    
}
}

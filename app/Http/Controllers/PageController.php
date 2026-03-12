<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Cart;
use App\Models\Category;
use App\Models\ContactInfo;
use App\Models\Heritage;
use App\Models\PaymentSetting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $categories = Category::where('status', 'active')->get();
        return view('ecommerce-project.index', compact('categories'));
    }

    public function shop()
    {
        $categories = Category::where('status', 'active')->get();
        $products = Product::withCount(['reviews' => function ($q) {
            $q->where('status', 'approved');
        }])
            ->withAvg(['reviews' => function ($q) {
                $q->where('status', 'approved');
            }], 'rating')
            ->get();
        return view('ecommerce-project.shop', compact('categories'));
    }


    public function account()
    {
        $categories = Category::where('status', 'active')->get();

        return view('ecommerce-project.account', compact('categories'));
    }

    public function updateAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'current_password' => 'nullable',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->date_of_birth = $validated['date_of_birth'];

        if ($request->filled('password')) {

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Current password is incorrect'
                ]);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('ecommerce-project.account')
            ->with('success', 'Profile updated successfully');
    }

    public function artisans()
    {
        $heritages = Heritage::where('status', 'active')
            ->orderBy('order')
            ->get();


        $categories = Category::where('status', 'active')->get();
        $artisans = Artisan::with('category')
            ->where('status', 'active')
            ->get();
        return view('ecommerce-project.artisans', compact('categories', 'heritages', 'artisans'));
    }



    public function contact()
    {


        $contact = ContactInfo::first();
        $products = Product::all();
        $categories = Category::where('status', 'active')->get();
        return view('ecommerce-project.contact', compact('categories', 'contact', 'products'));
    }

    public function checkout()
    {
        $items = Cart::where('user_id', auth()->id())->with('product')->get();

        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $stripeKey = DB::table('setting_payment')
            ->where('key', 'stripe_public_key')
            ->value('value');
        $categories = Category::where('status', 'active')->get();

        return view('ecommerce-project.checkout', compact('stripeKey', 'categories', 'items', 'subtotal'));
    }
}

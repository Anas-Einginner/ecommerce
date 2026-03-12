<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'html' => view(
                'ecommerce-project.partials.cart-modal',
                compact('items', 'subtotal')
            )->render(),

            'count' => $items->sum('quantity'),

            'total' => number_format($subtotal, 2)
        ]);
    }
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $product = Product::findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1; // ✅ استقبل الكمية
        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => 0,
                'price' => $product->price
            ]
        );

        $cart->increment('quantity', $quantity); // ✅ زيادة الكمية المحددة

        return response()->json(['status' => 'success']);
    }

    public function count()
    {
        $count = Cart::where('user_id', auth()->id())
            ->sum('quantity');

        return response()->json(['count' => $count]);
    }
    public function addAll()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();
       

        foreach ($wishlistItems as $item) {

            if (!$item->product) continue;

            $cart = Cart::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'product_id' => $item->product_id
                ],
                [
                    'quantity' => 0,
                    'price' => $item->product->price
                ]
            );

          
        $cart->increment('quantity');
        }

        return response()->json(['status' => 'success']);
    }


    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($request->type == 'plus') {
            $cart->increment('quantity');
        }

        if ($request->type == 'minus' && $cart->quantity > 1) {
            $cart->decrement('quantity');
        }

        $items = Cart::where('user_id', auth()->id())->get();

        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'quantity' => $cart->quantity,
            // 'subtotal' => number_format($subtotal,2),
            'total' => number_format($subtotal, 2),
            'count' => $items->sum('quantity')
        ]);
    }

    public function remove(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart) {
            return response()->json(['error' => 'not found'], 404);
        }

        $cart->delete();

        $items = Cart::where('user_id', auth()->id())->get();

        $subtotal = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2),
            'count' => $items->sum('quantity')
        ]);
    }
}

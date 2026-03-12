<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $html = view('ecommerce-project.partials.wishlist-items', compact('wishlist'))->render();

        return response()->json([
            'html' => $html,
            'count' => $wishlist->count()
        ]);
    }
public function toggle(Request $request)
{
    $product = Product::findOrFail($request->product_id);

    $wishlistItem = Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->first();

    if ($wishlistItem) {
        $wishlistItem->delete();

        return response()->json([
            'status' => 'removed',
            'name' => $product->name
        ]);
    }

    Wishlist::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id
    ]);

    return response()->json([
        'status' => 'added',
        'name' => $product->name
    ]);
}

    public function count()
    {
        $count = Wishlist::where('user_id', auth()->id())->count();
        return response()->json(['count' => $count]);
    }

  public function remove($id)
{
    $wishlistItem = Wishlist::findOrFail($id);
    $name = $wishlistItem->product->name;

    $wishlistItem->delete();

    return response()->json([
        'success' => true,
        'name' => $name
    ]);
}
}

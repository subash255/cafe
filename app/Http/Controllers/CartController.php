<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Fooditems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        // Logic to display the cart items can be added here
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('user.cart', compact('cartItems'));
    }

public function store(Request $request)
{
    // 1.  Must be logged in
    if (!Auth::check()) {
        return redirect()
            ->route('login')
            ->with('error', 'You must be logged in to add items to the cart.');
    }

    // 2.  Validate input
    $data = $request->validate([
        'fooditem_id' => 'required|exists:fooditems,id',
        'quantity'    => 'required|integer|min:1',
        // It’s safer to recalc price from the DB, so price is optional here
    ]);

    // 3.  Fetch (or create) the cart line for this user & item
    $cartLine = Cart::where('user_id', Auth::id())
                    ->where('fooditem_id', $data['fooditem_id'])
                    ->first();

    if ($cartLine) {
        // 🔄 Already in cart → just bump quantity
        $cartLine->quantity += $data['quantity'];
    } else {
        // ➕ First time this item is added
        $cartLine            = new Cart();
        $cartLine->user_id   = Auth::id();
        $cartLine->fooditem_id = $data['fooditem_id'];
        $cartLine->quantity  = $data['quantity'];
    }

    // 4.  Always keep price in sync with the latest menu price
    //     (prevents tampering from the client side)
    $food = Fooditems::select('price')->find($data['fooditem_id']);
    $cartLine->price = $food->price;

    $cartLine->save();

    return back()->with('success', 'Item added to cart successfully!');
}

public function destroy($id)
{
    // 1.  Must be logged in
    if (!Auth::check()) {
        return redirect()
            ->route('login')
            ->with('error', 'You must be logged in to remove items from the cart.');
    }

    // 2.  Find the cart line
    $cartLine = Cart::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->first();

    if (!$cartLine) {
        return back()->with('error', 'Item not found in your cart.');
    }

    // 3.  Delete it
    $cartLine->delete();

    return back()->with('success', 'Item removed from cart successfully!');
}
}

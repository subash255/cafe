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

public function store(Request $request , $id)
{
    // 1.  Must be logged in
    if (!Auth::check()) {
        return redirect()
            ->route('login')
            ->with('error', 'You must be logged in to add items to the cart.');
    }

    // 2.  Validate input
    $data = $request->validate([

        'quantity'    => 'required|integer|min:1',
        // It’s safer to recalc price from the DB, so price is optional here
    ]);
     $cartLine = Cart::firstOrNew([
            'user_id'     => Auth::id(),
            'fooditem_id' => $id,
        ]);
        $fooditem = Fooditems::findOrFail($id);

        $cartLine->quantity = ($cartLine->exists ? $cartLine->quantity : 0) + $data['quantity'];
        $cartLine->price    = $fooditem->price;      // always sync with DB price
        $cartLine->save();

    return back()->with('success', 'Item added to cart successfully!');
}

public function destroy($item)
{
    $cartLine = Cart::findOrFail($item);

    abort_unless($cartLine->user_id === Auth::id(), 403);

    $cartLine->delete();

    return back()->with('success', 'Item removed from cart successfully!');
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Fooditems;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\EsewaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('fooditem')
            ->get();
        
        $grandTotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('user.cart', compact('cartItems', 'grandTotal'));
    }

    public function store(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'You must be logged in to add items to the cart.');
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartLine = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'fooditem_id' => $id,
        ]);

        $fooditem = Fooditems::findOrFail($id);

        if ($cartLine->exists) {
            $cartLine->quantity += $data['quantity'];
        } else {
            $cartLine->quantity = $data['quantity'];
        }
        
        $cartLine->price = $fooditem->price;
        $cartLine->save();

        return back()->with('success', 'Item added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartLine = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartLine->quantity = $data['quantity'];
        $cartLine->save();

        return back()->with('success', 'Cart updated successfully!');
    }

    public function destroy($id)
    {
        $cartLine = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartLine->delete();

        return back()->with('success', 'Item removed from cart successfully!');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('fooditem')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $grandTotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('user.checkout', compact('cartItems', 'grandTotal'));
    }

    public function processPayment(Request $request)
    {
        $data = $request->validate([
            'payment_method' => 'required|in:cash_on_delivery,esewa',
            'delivery_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('fooditem')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $grandTotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $grandTotal,
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'cash_on_delivery' ? 'pending' : 'pending',
                'order_status' => 'pending',
                'delivery_address' => $data['delivery_address'],
                'phone_number' => $data['phone_number'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'fooditem_id' => $cartItem->fooditem_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->quantity * $cartItem->price,
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            if ($data['payment_method'] === 'esewa') {
                return $this->initiateEsewaPayment($order);
            } else {
                return redirect()->route('order.success', $order->id)
                    ->with('success', 'Order placed successfully! You will pay on delivery.');
            }

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function initiateEsewaPayment($order)
    {
        $esewaService = new EsewaService();
        $paymentParams = $esewaService->getPaymentParams($order);

        // Store transaction UUID in order for later verification
        $order->update(['payment_reference' => $paymentParams['transaction_uuid']]);

        return view('user.esewa-payment', compact('paymentParams', 'order'));
    }

    public function esewaSuccess(Request $request)
    {
        $data = $request->query('data');
        
        if (!$data) {
            return redirect()->route('cart.index')
                ->with('error', 'Invalid response from eSewa.');
        }

        // Decode the base64 response
        $decodedData = json_decode(base64_decode($data), true);

        if (!$decodedData) {
            return redirect()->route('cart.index')
                ->with('error', 'Invalid response format from eSewa.');
        }

        // Verify signature
        $esewaService = new EsewaService();
        if (!$esewaService->verifySignature($decodedData)) {
            return redirect()->route('cart.index')
                ->with('error', 'Payment verification failed.');
        }

        // Find order by transaction UUID
        $transactionUuid = $decodedData['transaction_uuid'];
        $order = Order::where('payment_reference', $transactionUuid)->first();

        if (!$order) {
            return redirect()->route('cart.index')
                ->with('error', 'Order not found.');
        }

        // Update order status
        $order->update([
            'payment_status' => 'completed',
            'payment_reference' => $decodedData['transaction_code'],
        ]);

        return redirect()->route('order.success', $order->id)
            ->with('success', 'Payment successful! Your order has been confirmed.');
    }

    public function esewaFailure()
    {
        return redirect()->route('cart.index')
            ->with('error', 'Payment failed. Please try again.');
    }

    public function orderSuccess($orderId)
    {
        $order = Order::with('orderItems.fooditem', 'user')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.order-success', compact('order'));
    }
}

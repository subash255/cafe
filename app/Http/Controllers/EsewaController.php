<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EsewaController extends Controller
{

   public function checkout(Request $request)
{
    // 1. Make sure we really have a user
    $user = Auth::user();
    if (!$user) {
        return back()->with('error', 'Please log in before checking out.');
    }

    // 2. Fetch the cart
    $cartItems = Cart::with('fooditem')
                     ->where('user_id', $user->id)
                     ->get();

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Your cart is empty.');
    }

    // 3. Wrap everything in a DB transaction
    DB::transaction(function () use ($user, $cartItems, &$firstOrder) {
        foreach ($cartItems as $item) {
            $order = Order::create([
                'user_id'     => $user->id,
                'fooditem_id' => $item->fooditem_id,
                'amount'      => $item->price * $item->quantity,
                'status'      => 'pending',
            ]);

            // save first order so we can redirect later
            $firstOrder ??= $order;   // PHP 8 null‑coalescing assignment
        }

        // 4. Clear the cart
        Cart::where('user_id', $user->id)->delete();
    });

    // 5. Redirect to pay for the first order
    return redirect()
        ->route('esewa.pay', ['order' => $firstOrder->id])
        ->with('success', 'Order(s) created — complete your payment.');
}
      /**
     * 2) Build payload + signature, show form that auto‑submits to eSewa
     */
    public function pay(Order $order)
    {
        // numbers
        $amount = $order->amount;           // subtotal (no tax) – for demo set same as total
        $tax    = 0;
        $total  = $amount + $tax;

        // required three “signed fields”
        $fields = [
            'total_amount'     => $total,
            'transaction_uuid' => $order->id . '-' . now()->timestamp,
            'product_code'     => config('app.esewa_merchant_code', env('ESEWA_MERCHANT_CODE')),
        ];

        // build the canonical string
        $stringToSign = collect($fields)
            ->map(fn ($v, $k) => "{$k}={$v}")
            ->implode(',');

        $signature = base64_encode(hash_hmac(
            'sha256',
            $stringToSign,
            env('ESEWA_SECRET_KEY'),
            true
        ));

        // everything the view needs
        $payload = array_merge($fields, [
            'amount'                  => $amount,
            'tax_amount'              => $tax,
            'product_service_charge'  => 0,
            'product_delivery_charge' => 0,
            'success_url'             => route('esewa.success'),
            'failure_url'             => route('esewa.failure'),
            'signed_field_names'      => implode(',', array_keys($fields)),
            'signature'               => $signature,
            'form_action'             => env('ESEWA_FORM_URL'),
        ]);

        return view('esewa.pay', compact('payload', 'order'));
    }

    /**
     * 3) User comes back here via success_url
     *    We hit eSewa’s verify API to be sure the payment is real
     */
    public function success(Request $request)
    {
        $refId = $request->input('reference_id');      // new v2 field
        $oid   = $request->input('transaction_uuid');  // we attached our order id at the front

        // verify via API
        $verify = Http::asForm()->post(env('ESEWA_VERIFY_URL'), [
            'reference_id'      => $refId,
            'product_code'      => env('ESEWA_MERCHANT_CODE'),
            'transaction_uuid'  => $oid,
        ]);

        $data = $verify->json();

        if (($data['status'] ?? '') === 'COMPLETE') {
            // mark order paid
            [$orderId] = explode('-', $oid);           // pull original id
            if ($order = Order::find($orderId)) {
                $order->update(['status' => 'paid', 'paid_reference' => $refId]);
            }

            return redirect()->route('cart.index')->with('success', 'Payment successful!');
        }

        return redirect()->route('cart.index')->with('error', 'Verification failed.');
    }

    /** 4) Failure route – nothing fancy */
    public function failure()
    {
        return redirect()->route('cart.index')->with('error', 'Payment cancelled.');
    
}
}


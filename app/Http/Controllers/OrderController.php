<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.fooditem'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.fooditem'])
            ->findOrFail($id);
            
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Delete related order items first
        $order->orderItems()->delete();
        
        // Delete the order
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully!');
    }

    public function getOrderStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'processing_orders' => Order::where('order_status', 'processing')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),
            'cancelled_orders' => Order::where('order_status', 'cancelled')->count(),
            'total_revenue' => Order::where('order_status', '!=', 'cancelled')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('order_status', '!=', 'cancelled')
                ->sum('total_amount'),
        ];

        return response()->json($stats);
    }

    public function print($id)
    {
        $order = Order::with(['user', 'orderItems.fooditem'])
            ->findOrFail($id);
            
        return view('admin.order.print', compact('order'));
    }
}

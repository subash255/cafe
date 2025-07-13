<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Fooditems;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function index()
    {
        // Get dynamic statistics
        $totalCategories = Category::count();
        $totalFoodItems = Fooditems::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalReservations = Reservation::count();
        $totalSales = Order::where('order_status', '!=', 'cancelled')->sum('total_amount');

        // Get category data for pie chart
        $categories = Category::withCount('fooditems')->get();
        $categoryData = $categories->map(function($category) {
            return [
                'name' => $category->name,
                'count' => $category->fooditems_count,
                'color' => $this->generateCategoryColor($category->id)
            ];
        });

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get recent reservations
        $recentReservations = Reservation::latest()
            ->take(3)
            ->get();

        // Get popular items (most ordered)
        $popularItems = OrderItem::with('fooditem')
            ->selectRaw('fooditem_id, SUM(quantity) as total_quantity')
            ->groupBy('fooditem_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalFoodItems', 
            'totalOrders',
            'pendingOrders',
            'totalReservations',
            'totalSales',
            'categoryData',
            'recentOrders',
            'recentReservations',
            'popularItems'
        ));
    }

    private function generateCategoryColor($id)
    {
        $colors = [
            '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
            '#06b6d4', '#f97316', '#84cc16', '#ec4899', '#6366f1'
        ];
        return $colors[$id % count($colors)];
    }
}

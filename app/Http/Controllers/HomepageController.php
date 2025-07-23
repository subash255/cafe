<?php

namespace App\Http\Controllers;

use App\Models\Fooditems;
use App\Models\Category;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $menus = Fooditems::all();
        $popularItems = Fooditems::popular()->limit(6)->get(); // Use scope for popular items
        
        // Get recommended items for logged in users based on their cart
        $recommendedItems = collect();
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get cart items with their categories
            $cartItems = Cart::where('user_id', $user->id)
                ->with('fooditem.category')
                ->get();
            
            if ($cartItems->isNotEmpty()) {
                // Get unique categories from cart items
                $cartCategories = $cartItems->pluck('fooditem.category.id')
                    ->filter()
                    ->unique()
                    ->values();
                
                if ($cartCategories->isNotEmpty()) {
                    // Get cart item IDs to exclude
                    $cartItemIds = $cartItems->pluck('fooditem_id');
                    
                    // Get recommended items from these categories (excluding items already in cart)
                    $recommendedItems = Fooditems::with('category')
                        ->whereIn('category_id', $cartCategories)
                        ->whereNotIn('id', $cartItemIds)
                        ->inRandomOrder()
                        ->limit(8)
                        ->get();
                }
            }
        }
        
        return view('welcome', compact('menus', 'popularItems', 'recommendedItems'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function menu()
    {
        $menus = Fooditems::with('category')->get();
        $categories = Category::all();
        $popularItems = Fooditems::popular()->limit(8)->get(); // Use scope for popular items
        
        // Get recommended items for logged in users based on their cart
        $recommendedItems = collect();
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get cart items with their categories
            $cartItems = Cart::where('user_id', $user->id)
                ->with('fooditem.category')
                ->get();
            
            if ($cartItems->isNotEmpty()) {
                // Get unique categories from cart items
                $cartCategories = $cartItems->pluck('fooditem.category.id')
                    ->filter()
                    ->unique()
                    ->values();
                
                if ($cartCategories->isNotEmpty()) {
                    // Get cart item IDs to exclude
                    $cartItemIds = $cartItems->pluck('fooditem_id');
                    
                    // Get recommended items from these categories (excluding items already in cart)
                    $recommendedItems = Fooditems::with('category')
                        ->whereIn('category_id', $cartCategories)
                        ->whereNotIn('id', $cartItemIds)
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();
                }
            }
        }
        
        return view('menu', compact('menus', 'categories', 'popularItems', 'recommendedItems'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's total orders count
        $totalOrders = Order::where('user_id', $user->id)->count();
        
        // Get user's total reservations count (using email to match since no user_id in reservations table)
        $totalReservations = Reservation::where('email', $user->email)->count();
        
        // Get recent orders with food items (last 5)
        $recentOrders = Order::with('orderItems.fooditem')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent reservations (last 5) using email to match
        $recentReservations = Reservation::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact('totalOrders', 'totalReservations', 'recentOrders', 'recentReservations'));
    }
}

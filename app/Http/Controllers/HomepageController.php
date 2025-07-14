<?php

namespace App\Http\Controllers;

use App\Models\Fooditems;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
         $menus = Fooditems::all();
        return view('welcome', compact('menus'));
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
        $menus = Fooditems::all();
        // Logic for displaying the menu can be added here
        return view('menu',compact('menus'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Fooditems;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        return view('welcome');
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
        // User dashboard - show user's reservations, order history, etc.
        return view('dashboard');
    }
}

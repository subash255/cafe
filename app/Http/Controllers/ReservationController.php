<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations= Reservation::all();
        return view('admin.reservation.index',compact('reservations'));
    }

    public function store(Request  $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:255',
            'phone'=>'required|string|max:255',
            'email'=>'required|email',
            'date'=>'required|date',
            'time'=>'required|string|max:255',
            'people'=>'required|numeric',
        ]);

        Reservation::create($data);
        return redirect()->back()->with('success','Reservation created successfully');
    }

    public function destroy($id)
    {
        Reservation::destroy($id);
        return redirect()->back()->with('success','Reservation deleted successfully');
    }
}

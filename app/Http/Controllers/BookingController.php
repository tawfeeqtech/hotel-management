<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    // All Booking
    public function allBooking()
    {
        return view('pages.Booking.all-booking');
    }

    // All Booking
    public function bookingEdit()
    {
        return view('pages.Booking.edit');
    }
    
    // booking add
    public function bookingAdd()
    {
        // $data = DB::table('room_types')->get();
        // $user = DB::table('users')->get();
        // return view('pages.Booking.create',compact('data','user'));
        return view('pages.Booking.create');
    }

    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'room_type'     => 'required|string|max:255',
            'total_numbers' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'arrival_date'  => 'required|string|max:255',
            'depature_date' => 'required|string|max:255',
            'email'      => 'required|string|max:255',
            'phone_number'  => 'required|string|max:255',
            'fileupload' => 'required|file',
            'message'    => 'required|string|max:255',
        ]);

    }
}

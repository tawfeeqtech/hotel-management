<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
}

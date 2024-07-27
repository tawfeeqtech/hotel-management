<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    // All Booking
    public function index()
    {
        $Bookings = DB::table('bookings')->get();
        return view('pages.booking.index',compact('Bookings'));
    }

    // edit Booking
    public function edit($bkg_id)
    {
        $bookingEdit = DB::table('bookings')->where('bkg_id',$bkg_id)->first();
        return view('pages.booking.edit',compact('bookingEdit'));
    }
    
    // booking add
    public function create()
    {
        $data = DB::table('room_types')->get();
        $user = DB::table('users')->get();
        return view('pages.booking.create',compact('data','user'));
    }

    public function store(Request $request)
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

        
        DB::beginTransaction();
        try {

            $photo= $request->fileupload;
            $file_name = rand() . '.' .$photo->getClientOriginalName();
            $photo->move(public_path('/assets/upload/booking/'), $file_name);
           
            $booking = new Booking;
            $booking->name = $request->name;
            $booking->room_type     = $request->room_type;
            $booking->total_numbers  = $request->total_numbers;
            $booking->date  = $request->date;
            $booking->time  = $request->time;
            $booking->arrival_date   = $request->arrival_date;
            $booking->depature_date  = $request->depature_date;
            $booking->email       = $request->email;
            $booking->ph_number   = $request->phone_number;
            $booking->fileupload  = $file_name;
            $booking->message     = $request->message;

            $booking->save();
            
            DB::commit();
            toastr()->success('Create new booking successfully :');
            return to_route('bookings.index');

        } catch(\Exception $e) {
            DB::rollback();
            toastr()->error('Add Booking fail! :');
            return redirect()->back();
        }


    }

    // update record
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->fileupload)) {
                $photo = $request->fileupload;
                $file_name = rand() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('/assets/upload/booking/'), $file_name);

                $old_path_file = Booking::where('bkg_id',$request->bkg_id)->select('fileupload')->first();
                $old_path_file = $old_path_file->fileupload;
                unlink('assets/upload/booking/' . $old_path_file);


            } else {
                $file_name = $request->hidden_fileupload;
            }

            $update = [
                'bkg_id' => $request->bkg_id,
                'name'   => $request->name,
                'room_type'  => $request->room_type,
                'total_numbers' => $request->total_numbers,
                'date'   => $request->date,
                'time'   => $request->time,
                'arrival_date'   => $request->arrival_date,
                'depature_date'  => $request->depature_date,
                'email'   => $request->email,
                'ph_number' => $request->phone_number,
                'fileupload'=> $file_name,
                'message'   => $request->message,
            ];

            Booking::where('bkg_id',$request->bkg_id)->update($update);
        
            DB::commit();
            toastr()->success('Updated booking successfully :');
            return to_route('bookings.index');
        } catch(\Exception $e) {
            DB::rollback();
            toastr()->error('Update booking fail! :');
            return to_route('bookings.index');
        }
    }

    // delete record booking
    public function destroy(Request $request)
    {
        try {

            Booking::destroy($request->id);
            unlink('assets/upload/booking/'.$request->fileupload);
            toastr()->success('Booking deleted successfully :');
            return redirect()->back();
        
        } catch(\Exception $e) {

            DB::rollback();
            toastr()->error('Booking delete fail! :');
            return redirect()->back();
        }
    }

}

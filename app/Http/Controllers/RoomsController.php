<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = DB::table('rooms')->get();
        return view('pages.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('room_types')->get();
        $user = DB::table('users')->get();
        return view('pages.rooms.create', compact('user', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'room_type'     => 'required|string|max:255',
            'ac_non_ac'     => 'required|string|max:255',
            'food'          => 'required|string|max:255',
            'bed_count'     => 'required|string|max:255',
            'charges_for_cancellation' => 'required|string|max:255',
            'rent'          => 'required|string|max:255',
            'phone_number'  => 'required|string|max:255',
            'fileupload'    => 'required|file',
            'message'       => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $photo = $request->fileupload;
            $file_name = rand() . '.' . $photo->getClientOriginalName();
            $photo->move(public_path('/assets/upload/rooms/'), $file_name);

            $room = new Room;
            $room->name         = $request->name;
            $room->room_type    = $request->room_type;
            $room->ac_non_ac    = $request->ac_non_ac;
            $room->food         = $request->food;
            $room->bed_count    = $request->bed_count;
            $room->charges_for_cancellation   = $request->charges_for_cancellation;
            $room->rent         = $request->rent;
            $room->phone_number = $request->phone_number;
            $room->fileupload   = $file_name;
            $room->message      = $request->message;
            $room->save();

            DB::commit();
            toastr()->success('Create new room successfully :');
            return redirect()->route('rooms.index');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Add Room fail! :');
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bkg_room_id)
    {
        $room = DB::table('rooms')->where('bkg_room_id', $bkg_room_id)->first();
        $data = DB::table('room_types')->get();
        $user = DB::table('users')->get();
        return view('pages.rooms.edit', compact('user', 'data', 'room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->fileupload)) {
                $photo = $request->fileupload;
                $file_name = rand() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('/assets/upload/rooms/'), $file_name);

                $old_path_file = Room::where('bkg_room_id', $request->bkg_room_id)->select('fileupload')->first();
                $old_path_file = $old_path_file->fileupload;
                unlink('assets/upload/rooms/' . $old_path_file);
            } else {
                $file_name = $request->hidden_fileupload;
            }

            $update = [
                'bkg_room_id' => $request->bkg_room_id,
                'name'   => $request->name,
                'room_type'  => $request->room_type,
                'ac_non_ac'  => $request->ac_non_ac,
                'food'  => $request->food,
                'bed_count'  => $request->bed_count,
                'charges_for_cancellation'  => $request->charges_for_cancellation,
                'phone_number' => $request->phone_number,
                'fileupload' => $file_name,
                'message'   => $request->message,
            ];
            Room::where('bkg_room_id', $request->bkg_room_id)->update($update);

            DB::commit();
            toastr()->success('Updated room successfully :');
            return redirect()->route('rooms.index');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error('Update room fail! :');
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            Room::destroy($request->id);
            unlink('assets/upload/rooms/' . $request->fileupload);
            toastr()->success('Room deleted successfully :');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Room delete fail! :');
            return redirect()->back();
        }
    }
}

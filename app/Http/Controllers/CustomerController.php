<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = DB::table('customers')->get();
        return view('pages.customers.index',compact('customers'));
        // return view('pages.Customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = DB::table('room_types')->get();
        $user = DB::table('users')->get();
        return view('pages.customers.create',compact('data','user'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $photo->move(public_path('/assets/upload/'), $file_name);
           
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->room_type     = $request->room_type;
            $customer->total_numbers  = $request->total_numbers;
            $customer->date  = $request->date;
            $customer->time  = $request->time;
            $customer->arrival_date   = $request->arrival_date;
            $customer->depature_date  = $request->depature_date;
            $customer->email       = $request->email;
            $customer->ph_number   = $request->phone_number;
            $customer->fileupload  = $file_name;
            $customer->message     = $request->message;
            $customer->save();
            
            DB::commit();

            toastr()->success('Create new customer successfully :');
            return redirect()->route('customers.index');
            
        } catch(\Exception $e) {
            DB::rollback();

            toastr()->error('Add Customer fail! :');
            return redirect()->back();
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
    public function edit($bkg_customer_id)
    {
        $customerEdit = DB::table('customers')->where('bkg_customer_id',$bkg_customer_id)->first();
        return view('pages.customers.edit',compact('customerEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->fileupload)) {
                $photo = $request->fileupload;
                $file_name = rand() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('/assets/upload/'), $file_name);
            } else {
                $file_name = $request->hidden_fileupload;
            }

            $update = [
                'bkg_customer_id' => $request->bkg_customer_id,
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
            Customer::where('bkg_customer_id',$request->bkg_customer_id)->update($update);
            DB::commit();
            toastr()->success('Updated customer successfully :');
            return redirect()->route('customers.index');
        } catch(\Exception $e) {
            DB::rollback();
            toastr()->error('Update customer fail! :');
            // return redirect()->back();
           return redirect()->route('customers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Charging;
use App\Models\ChargingDetails;
use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ChargingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $chargings = Charging::with(['device', 'card', 'location'])->get();
        $chargings = Charging::with('details.device', 'details.location','details.card')->get();

        return view('pages.chargings.index', compact('chargings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devices = Device::all();
        $cards = Card::all();
        $locations = Location::all();
        return view('pages.chargings.create', compact('devices', 'cards', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'customer_name' => 'required',
            'device_id.*' => 'required|exists:devices,id',
            'with_charger.*' => 'required|boolean',
//            'location_id.*' => 'required|exists:locations,id',
            'location_id.*' => [
                'required',
                Rule::unique('charging_details', 'location_id')->where(function ($query) use ($request) {
                    return $query->where('receiving_status', '!=', 'received');
                }),
            ],
//            'card_id' => 'required|exists:cards,id',
            'card_id' => [
                'required',
                Rule::unique('charging_details', 'card_id')->where(function ($query) use ($request) {
                    return $query->where('receiving_status', '!=', 'received');
                }),

            ],

            'charging_start_time' => 'required|date',
//            'delivery_time' => 'nullable|date',
//            'receiving_status' => 'nullable|string',
            'payment_status' => 'required',
            'total_price' => 'required|numeric',
        ], [
            'location_id.*.unique' => 'رقم المكان المحدد قيد الاستخدام حاليًا ولم يتم تسليم الاجهزة بعد.',
            'card_id' => 'رقم البطاقة المحددة قيد الاستخدام حاليًا ولم يتم تسليمها بعد.',
        ]);

        //Charging::create($request->all());
//        $data = $request->all();
//
//        if ($request->payment_status === '1 remaining') {
//            $request->validate([
//                'remaining_value' => 'required|numeric',
//            ]);
//            $data['remaining_value'] = $request->remaining_value;
//        } else {
//            $data['remaining_value'] = null;
//        }
//
//        Charging::create($data);

        if ($request->payment_status === '1 remaining') {
            $request->validate([
                'remaining_value' => 'required|numeric',
            ]);
        }

        $charging = Charging::create([
            'customer_name' => $request->customer_name,
            'payment_status' => $request->payment_status,
            'remaining_value' => $request->payment_status === '1 remaining' ? $request->remaining_value : null,
            'total_price' => $request->total_price,
        ]);

        foreach ($request->device_id as $index => $device_id) {
            ChargingDetails::create([
                'charging_id' => $charging->id,
                'card_id' => $request->card_id,
                'device_id' => $device_id,
                'with_charger' => $request->with_charger[$index],
                'location_id' => $request->location_id[$index],
                'receiving_status' => 'not_received',
                'charging_start_time' => $request->charging_start_time,
                'delivery_time' => null,
            ]);
        }

    /*
        $data = $request->all();

        foreach ($data['device_id'] as $key => $device_id) {
            Charging::create([
                'customer_name' => $data['customer_name'],
                'device_id' => $device_id,
                'with_charger' => $data['with_charger'][$key],
                'location_id' => $data['location_id'][$key],
                'card_id' => $data['card_id'],
                'charging_start_time' => $data['charging_start_time'],
                'payment_status' => $data['payment_status'],
                'remaining_value' => $data['payment_status'] === '1 remaining' ? $data['remaining_value'] : null,
                'total_price' => $data['total_price'],
            ]);
        }*/

        return redirect()->route('chargings.index')->with('success', 'تم اضافة الزبون.');
    }

    public function updateStatus(Request $request, $id)
    {
        $charging = Charging::findOrFail($id);
        $charging->payment_status = $request->payment_status;
        if ($request->payment_status == '1 remaining') {
            $request->validate([
                'remaining_value' => 'required|numeric',
            ]);
            $charging->remaining_value = $request->remaining_value;
        } else {
            $charging->remaining_value = null;
        }
        $charging->save();

        return redirect()->route('chargings.index')
            ->with('success', 'تم تحديث البيانات بنجاح.');
    }

    public function updateReceivingStatus(Request $request, $id)
    {
        $charging = Charging::findOrFail($id);
        $charging->receiving_status = $request->receiving_status;
        if ($request->receiving_status == 'received') {
            $charging->delivery_time = now();
        }
        $charging->save();

        return redirect()->route('chargings.index')
            ->with('success', 'تم تحديث البيانات بنجاح.');
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
    public function edit(string $id)
    {
        $charging = Charging::find($id);
        $devices = Device::all();
        $cards = Card::all();
        $locations = Location::all();
        return view('pages.chargings.edit', compact('charging', 'devices', 'cards', 'locations'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'device_id.*' => 'required|exists:devices,id',
            'with_charger.*' => 'required|boolean',
            'location_id.*' => 'required|exists:locations,id',
            'card_id' => 'required|exists:cards,id',
            'charging_start_time' => 'required|date',
            'payment_status' => 'required',
            'total_price' => 'required|numeric',
        ]);

        if ($request->payment_status === '1 remaining') {
            $request->validate([
                'remaining_value' => 'required|numeric',
            ]);
        }

        $charging = Charging::find($id);
        $charging->update([
            'customer_name' => $request->customer_name,
            'device_id' => $request->device_id,
            'with_charger' => $request->with_charger,
            'location_id' => $request->location_id,
            'card_id' => $request->card_id,
            'charging_start_time' => $request->charging_start_time,
            'payment_status' => $request->payment_status,
            'remaining_value' => $request->payment_status === '1 remaining' ? $request->remaining_value : null,
            'total_price' => $request->total_price,
            'receiving_status' => $request->receiving_status,
        ]);

        return redirect()->route('chargings.index')
            ->with('success', 'تم تعديل البيانات بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $charging = Charging::find($id);
        $charging->delete();

        return redirect()->route('chargings.index')
            ->with('success', 'تم حذف البيانات بنجاح.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string',
            'photo' => 'required|image',
        ]);

        Log::info($request->user());

        $user = $request->user();
        $data = $request->all();
        $data['user_id'] = $user->id;

        $driver = Driver::create($data);

        //check if photo is uploaded
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $driver->photo = $photo_name;
            $driver->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Driver registered successfully',
            'data' => $driver
        ], 200);
    }
}

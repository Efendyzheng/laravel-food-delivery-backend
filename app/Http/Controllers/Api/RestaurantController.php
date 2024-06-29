<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'photo' => 'required|image',
            'latlong' => 'required|string',
        ]);

        $user = $request->user();
        $data = $request->all();
        $data['user_id'] =  $user->id;


        $restaurant = Restaurant::create($data);

        //check if photo is uploaded
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $restaurant->photo = $photo_name;
            $restaurant->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Restaurant registered successfully',
            'data' => $restaurant
        ], 200);
    }


    public function index()
    {
        $restaurants = Restaurant::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Get all restaurant',
            'data' => $restaurants
        ]);
    }
}

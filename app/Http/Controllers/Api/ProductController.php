<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('user')->where('user_id', $request->user()->id)->get();


        return response()->json([
            'status' => 'success',
            'message' => 'Product data loaded successfully',
            'data' => $products
        ]);
    }

    public function getProductByUserId(Request $request)
    {
        $products = Product::with('user')->where('user_id', $request->user_id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Product data loaded successfully',
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'is_available' => 'required|boolean',
            'is_favorite' => 'required|boolean',
            // 'image' => 'required|image',
        ]);

        $user = $request->user();
        $data = $request->all();

        $data['restaurant_id'] =  $user->restaurant->id;

        $product = Product::create($data);

        //check if image is available
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/products', $image_name);

            $product->image = $image_name;
            $product->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'is_available' => 'required|boolean',
            'is_favorite' => 'required|boolean',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $data = $request->all();

        $product->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }
}

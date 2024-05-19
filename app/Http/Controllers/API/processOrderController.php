<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPost;
use App\Models\City;
use App\Models\Unit;
use App\Models\User;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class processOrderController extends Controller
{
    public function processOrder(Request $request)
    {
        // Validate order details
        $validator = Validator::make($request->all(), [
            'product_post_id' => 'required|exists:product_posts,id',
            'quantity' => 'required|integer|min:1',
            // Add any other validation rules as necessary
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid order details',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        // Retrieve the product post
        $productPost = ProductPost::findOrFail($request->product_post_id);
    
        // Ensure product quantity is sufficient
        if ($productPost->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient product quantity',
            ], 400);
        }
    
        // Create new order
        $order = new Order();
        $order->product_post_id = $productPost->id;
        $order->user_id = Auth::id();
        $order->quantity = $request->quantity;
        // You may need additional fields for an order, adjust accordingly
    
        // Calculate total price based on quantity and product price
        $order->total_price = $request->quantity * $productPost->price;
    
        // Save order
        $order->save();
    
        // Update product quantity
        $productPost->quantity -= $request->quantity;
        $productPost->save();
    
        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Order processed successfully',
            'data' => $order,
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::query()->orderBy('created_at', 'desc')->get();
        //
        return view('admin.product.index', ['products' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        error_log('------------------store hello -------------------');
        //
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $product = new Product();
        if ($request->hasFile('image')) {
            $images = $request->file('image');

            foreach ($images as $image) {
                $image_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                error_log($image_name);
            }
        }
        $product->stock = $data['stock'];
        $product->size = $data['size'];
        $product->price = $data['price'];
        $product->color = $data['color'];
        $product->description = $data['description'];
        $product->name = $data['name'];
        $product->save();
        return response()->json(['msg' => 'success', 'response' => 'Category added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
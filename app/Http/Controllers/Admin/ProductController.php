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
    public function index(Request $request)
    {
        $productsQuery = Product::query()->orderBy('created_at', 'desc');

        $search_query = $request->input('search_query');

        if ($search_query) {
            $productsQuery->where('name', 'like', '%' . $search_query . '%');
        }

        $products = $productsQuery->get();
        
            // if (empty($search_query)) {
            //     return redirect()->route('admin.product.index');
            // }

        return view('admin.product.index', ['products' => $products]);
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
        $allFiles = $request->allFiles();
        $imageFiles = [];
        foreach ($allFiles as $key => $file) {
            if (str_starts_with($key, 'image-')) {
                $imageFiles[$key] = $file;
            }
        }
        foreach ($imageFiles as $key => $file) {
            $name = time() . '.' . $file->getClientOriginalName();
        }
        // Convert file names to a comma-separated string
        $fileNames = [];
        foreach ($imageFiles as $file) {
            $image_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/categories/');
            $file->move($destinationPath, $image_name);
            $fileNames[] = $image_name;
        }
        $fileNamesString = implode(', ', $fileNames);
        $product->image = $fileNamesString;
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
        $data = $product->all();
        $id = $data['id'];
        $category = Product::where('id', $id)->first();
        $htmlresult = view('admin/product/edit', compact('category', 'parent_categories'))->render();
        $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
        return $finalResult;
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

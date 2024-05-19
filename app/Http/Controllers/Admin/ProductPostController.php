<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPost;
use Illuminate\Support\Facades\Validator;

class ProductPostController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductPost::query();
        $search_query = $request->input('search_query');
        if ($request->has('search_query') && !empty($search_query)) {
            $query->where(function ($query) use ($search_query) {
                $query->where('title', 'like', '%' . $search_query . '%')
                    ->orWhereHas('Vendor', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['posts'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin.posts.manage_posts', $data);
    }
    // public function store(Request $request)
    // {
    //     // validate user if theri profile is complete or not i.e. following fields must be filled: city_id, address, zip

    //     // $user = Auth::user();
    //     // if (!$user->city_id || !$user->address || !$user->zip) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Please complete your profile first',
    //     //     ], 400);
    //     // }
    //     // dd($user);
    //     $validee = Validator::make($request->all(), [
    //         'title' => 'required',
    //         'product_location' => 'required',
    //         'price' => 'required',
    //         'quantity' => 'required',
    //         'category_id' => 'required',
    //         'subcategory_id' => 'required',
    //     ]);

    //     if ($validee->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Please fill all required fields',
    //             'errors' => $validee->errors(),
    //         ], 400);
    //     }


    //     $ImageFiles = $request->images;
    //     $images = [];
    //     if ($ImageFiles != null) {
    //         foreach ($ImageFiles as $file) {
    //             $validator = Validator::make(
    //                 [
    //                     'file' => $file,
    //                     'extension' => strtolower($file->getClientOriginalExtension()),
    //                     'mime' => $file->getMimeType(),
    //                 ],
    //                 [
    //                     'file' => 'required|file',
    //                     'extension' => 'required|string|in:jpg,jpeg,png,jfif',
    //                     'mime' => 'required|string|in:image/jpeg,image/jfif,image/png',
    //                 ]
    //             );

    //             if ($validator->fails()) {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Invalid File',
    //                     'errors' => $validator->errors(),
    //                 ], 400);
    //             } else {
    //                 $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //                 $extension = $file->getClientOriginalExtension();
    //                 $name = 'prod_req_' . time() . '_' . uniqid() . '.' . $extension;
    //                 $destinationPath = public_path('/uploads/products');
    //                 $file->move($destinationPath, $name);
    //                 array_push($images, $name);
    //             }
    //         }
    //     }
    //     $prod_city = City::where('id', $request->product_location)->pluck('id')->first();
    //     $vendor_id = Auth::user()->id;
    //     // $vendor_location = Auth::user()->city->id;

    //     $post = new ProductPost();
    //     $post->title = $request->title;
    //     $post->product_location = $prod_city;
    //     $post->unit_id = $request->unit_id;
    //     $post->price = $request->price;
    //     $post->quantity = $request->quantity;
    //     $post->category_id = $request->category_id;
    //     $post->subcategory_id = $request->subcategory_id;
    //     $post->moisture = $request->moisture;
    //     $post->place_of_origin = $request->place_of_origin;
    //     $post->brand = $request->brand;
    //     $post->model_no = $request->model_no;
    //     $post->certification = $request->certification;
    //     $post->description = $request->description;
    //     $post->images = json_encode($images);
    //     $post->status = 1;
    //     $post->vendor_id = $vendor_id;
    //     // $post->vendor_location = $vendor_location;
    //     $post->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Product Post Created Successfully',
    //         'data' => $post
    //     ], 201);
    // }
    public function update_statuses(Request $request)
    {
        $data = $request->all();
        $status = ProductPost::where('id', $data['id'])->update([
            'status' => $data['status'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if ($status > 0) {
            if ($data['status'] == '1') {
                $finalResult = response()->json(['msg' => 'success', 'response' => "Product Post Enabled successfully."]);
            } else {
                $finalResult = response()->json(['msg' => 'success', 'response' => "Product Post Disabled successfully."]);
            }
            return $finalResult;
        } else {
            $finalResult = response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
            return $finalResult;
        }
    }
    public function post_details($id)
    {
        $post = ProductPost::where('id', $id)->first();

        if (!empty($post)) {
            $post = $this->addInformation($post);
            return view('admin/posts/post_details', compact('post'));
        }

        return view('common/admin_404');
    }
    public function addInformation($post)
    {
        $images = json_decode($post->images);
        $images = array_map(function ($item) {
            return url('/public/uploads/products/' . $item);
        }, $images);
        $vendor = $post->Vendor;
        $vendor->city;
        //  = $vendor->city;
        // ->city_name
        $post->vendor = $vendor;
        $post->product_location ;
        // = $post->Productcity->city_name;
        $post->vendor_location;
        // = $post->Vendorcity->city_name;
        $post->unit = $post->Unit->unit_name;
        $post->category = $post->title;
        $post->subcategory = $post->title;
        // SubCategory->
        $post->images = $images;

        return $post;
    }
}

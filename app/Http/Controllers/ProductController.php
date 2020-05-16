<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductCategories;
use Cloudder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
        ], [
            'name.required' => 'Please enter a Name.',
            'cost.required' => 'Please enter a Cost.',
        ]);
        $image_upload = $request->file('upload-image');
        $image_path = $image_upload->getRealPath();

        $image_url = Cloudder::upload($image_path);
        dd($image_url);
        //\Cloudder::upload($filename, $publicId, array $options, array $tags);
        $product = Product::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
        ]);
        $categories = Category::all();
        foreach ($categories as $cat) {
            $key = 'category-' . $cat->id;
            if ($request->$key) {
                ProductCategories::create([
                    'product_id' => $product->id,
                    'category_id' => $cat->id,
                ]);
            }
        }
        session()->flash('message', 'A New Product was Created.');
        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $selected_cats = [];
        foreach ($product->categories as $cat) {
            $selected_cats[] = $cat->category_id;
        }
        return view('products.edit', compact('product', 'categories', 'selected_cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
        ], [
            'name.required' => 'Please enter a Name.',
            'cost.required' => 'Please enter a Cost.',
        ]);
        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
        ]);
        $categories = Category::all();
        foreach ($categories as $cat) {
            $key = 'category-' . $cat->id;
            $existing = ProductCategories::where(['product_id' => $product->id, 'category_id' => $cat->id])->first();
            if ($request->$key) {
                if (!$existing) {
                    ProductCategories::create([
                        'product_id' => $product->id,
                        'category_id' => $cat->id,
                    ]);
                }
            } else {
                if ($existing) {
                    $existing->delete();
                }
                // remove if not selected
            }
        }
        session()->flash('message', 'Product Has Been Updated.');
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    // public function cloudinary_upload($file)
    // {
    //     \Cloudinary::config(array(
    //         "cloud_name" => env('CLOUDINARY_NAME'),
    //         "api_key" => env('CLOUDINARY_KEY'),
    //         "api_secret" => env('CLOUDINARY_SECRET'),
    //     ));

    //     \Cloudinary\Uploader::upload("/home/my_image.jpg");

    // }
}

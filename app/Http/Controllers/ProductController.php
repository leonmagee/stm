<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductCategories;
use App\ProductSubCategories;
use App\SubCategory;
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
        foreach ($products as $product) {
            $product->cost_format = number_format($product->cost, 2);
        }
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
        //$sub_categories = SubCategory::all();
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
        if ($image_upload) {
            $image_path = $image_upload->getRealPath();
            //Cloudder::upload($filename, $publicId, array $options, array $tags);
            $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
            $result = $cloudinaryWrapper->getResult();
            $url = $result['secure_url'];
        } else {
            $url = '';
        }

        $product = Product::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
            'img_url' => $url,
        ]);

        foreach ($request->attribute_names as $attribute) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'text' => $attribute,
            ]);
        }
        $cats_array = [];
        $categories = Category::all();
        foreach ($categories as $cat) {
            $key = 'category-' . $cat->id;
            if ($request->$key) {
                $cats_array[] = $cat->id;
                ProductCategories::create([
                    'product_id' => $product->id,
                    'category_id' => $cat->id,
                ]);
            }
        }
        $sub_categories = SubCategory::all();
        foreach ($sub_categories as $sub_cat) {
            $key = 'sub-category-' . $sub_cat->id;
            if ($request->$key) {
                $sub_category = SubCategory::find($sub_cat->id);
                if (in_array($sub_category->category_id, $cats_array)) {
                    ProductSubCategories::create([
                        'product_id' => $product->id,
                        'sub_category_id' => $sub_cat->id,
                    ]);
                }
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
        $selected_sub_cats = [];
        foreach ($product->sub_categories as $cat) {
            $selected_sub_cats[] = $cat->sub_category_id;
        }

        return view('products.edit', compact('product', 'categories', 'selected_cats', 'selected_sub_cats'));
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

        $image_upload = $request->file('upload-image');
        if ($image_upload) {
            $image_path = $image_upload->getRealPath();
            $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
            $result = $cloudinaryWrapper->getResult();
            $url = $result['secure_url'];
        } elseif ($request->img_url) {
            $url = $request->img_url;
        } else {
            $url = '';
        }

        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
            'img_url' => $url,
        ]);

        // 1. Delete existing attriubtes for product
        ProductAttribute::where('product_id', $product->id)->delete();

        // 2. Create new attributes
        foreach ($request->attribute_names as $attribute) {
            if ($attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'text' => $attribute,
                ]);
            }
        }

        $categories = Category::all();
        $cats_array = [];

        foreach ($categories as $cat) {
            $key = 'category-' . $cat->id;
            $existing = ProductCategories::where(['product_id' => $product->id, 'category_id' => $cat->id])->first();
            if ($request->$key) {
                $cats_array[] = $cat->id;
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
            }
        }

        $sub_categories = SubCategory::all();
        foreach ($sub_categories as $sub_cat) {
            $key = 'sub-category-' . $sub_cat->id;
            $existing = ProductSubCategories::where(['product_id' => $product->id, 'sub_category_id' => $sub_cat->id])->first();

            if ($request->$key) {
                if (!$existing) {
                    $sub_category = SubCategory::find($sub_cat->id);
                    if (in_array($sub_category->category_id, $cats_array)) {
                        ProductSubCategories::create([
                            'product_id' => $product->id,
                            'sub_category_id' => $sub_cat->id,
                        ]);
                    }
                }
            } else {
                if ($existing) {
                    $existing->delete();
                }

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

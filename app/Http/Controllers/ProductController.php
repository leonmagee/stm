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
    public $secondary_images;

    public function __construct()
    {
        $this->middleware('auth');
        $this->secondary_images = 3;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::with('categories')->get();
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->img_url) {
                $match = null;
                preg_match('(\/STM\/.*)', $product->img_url, $match);
                $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 600, "height" => 600, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                $product->img_url = $new_url;
            }
            $orig_cost = number_format($product->cost, 2);
            if ($product->discount) {
                $product->orig_price = $orig_cost;
                $product->cost_format = number_format($product->cost - ($product->cost * ($product->discount / 100)), 2);

            } else {
                $product->orig_price = null;
                $product->cost_format = $orig_cost;
            }
            // add cat array
            $cat_array = [];
            foreach ($product->categories as $cat) {
                $cat_array[] = $cat->category_id;
            }
            $product->cat_array = $cat_array;
            // add sub cat array
            $sub_cat_array = [];
            foreach ($product->sub_categories as $sub_cat) {
                $sub_cat_array[$sub_cat->sub_category->category->id][] = $sub_cat->sub_category_id;
            }
            $product->sub_cat_array = $sub_cat_array;
            $attributes_array = [];
            foreach ($product->attributes as $attribute) {
                if (count($attributes_array) < 4) {
                    $attributes_array[] = $attribute->text;
                }
            }
            $product->attributes_array = $attributes_array;
        }
        $sub_cat_match = [];
        $sub_cats = SubCategory::all();
        $sub_cats_array = [];
        foreach ($sub_cats as $sub_cat) {
            $sub_cat_match[$sub_cat->id] = $sub_cat->category_id;
            $sub_cats_array[] = $sub_cat->id;
        }
        $sub_cat_match = json_encode($sub_cat_match);
        $sub_cats_array = json_encode($sub_cats_array);

        $categories = Category::with('sub_categories')->get();
        return view('products.index', compact('categories', 'products', 'sub_cat_match', 'sub_cats_array'));
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
            'description' => $request->description,
            'details' => self::img_replace($request->details),
            'more_details' => self::img_replace($request->more_details),
            'img_url' => $url,
        ]);

        foreach ($request->attribute_names as $attribute) {
            if ($attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'text' => $attribute,
                ]);
            }
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
        if ($product->img_url) {
            $match = null;
            preg_match('(\/STM\/.*)', $product->img_url, $match);
            $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 800, "height" => 800, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
            $product->img_url = $new_url;
            $new_url_small = cloudinary_url($match[0], ["transformation" => ["width" => 300, "height" => 300, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
            $product->img_url_small_1 = $new_url_small;
        }

        for ($i = 1; $i <= (1 + $this->secondary_images); $i++) {
            if ($product->{"img_url_" . $i}) {
                $match = null;
                preg_match('(\/STM\/.*)', $product->{"img_url_" . $i}, $match);
                $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 800, "height" => 800, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                $product->{"img_url_" . $i} = $new_url;
                $new_url_small = cloudinary_url($match[0], ["transformation" => ["width" => 300, "height" => 300, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                $product->{"img_url_small_" . $i} = $new_url_small;
            }
        }

        $orig_cost = number_format($product->cost, 2);
        if ($product->discount) {
            $product->orig_price = $orig_cost;
            $product->cost = number_format($product->cost - ($product->cost * ($product->discount / 100)), 2);

        } else {
            $product->orig_price = null;
            $product->cost = $orig_cost;
        }
        $num_images = $this->secondary_images;

        return view('products.show', compact('product', 'num_images'));
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

        $num_images = $this->secondary_images;

        return view('products.edit', compact('product', 'categories', 'selected_cats', 'selected_sub_cats', 'num_images'));
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
        //dd($request);
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
        ], [
            'name.required' => 'Please enter a Name.',
            'cost.required' => 'Please enter a Cost.',
        ]);

        $image_upload = $request->file('upload-image');

        // if ($image_upload) {
        //     $image_path = $image_upload->getRealPath();
        //     $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
        //     $result = $cloudinaryWrapper->getResult();
        //     $url = $result['secure_url'];
        // } elseif ($request->img_url) {
        //     $url = $request->img_url;
        // } else {
        //     $url = '';
        // }

        for ($i = 1; $i <= (1 + $this->secondary_images); $i++) {
            ${"image_upload_" . $i} = $request->file('upload-image-' . $i);
            if (${"image_upload_" . $i}) {
                $image_path = ${"image_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
                $result = $cloudinaryWrapper->getResult();
                ${"url_" . $i} = $result['secure_url'];
            } elseif ($request->{"img_url_" . $i}) {
                ${"url_" . $i} = $request->{"img_url_" . $i};
            } else {
                ${"url_" . $i} = '';
            }

        }

        //dd($url);

        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
            'description' => $request->description,
            'details' => self::img_replace($request->details),
            'more_details' => self::img_replace($request->more_details),
            'img_url_1' => $url_1,
            'img_url_2' => $url_2,
            'img_url_3' => $url_3,
            'img_url_4' => $url_4,
            'img_url_5' => $url_5,
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
        return redirect('products/' . $product->id);
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

    /**
     * Replace image with icon
     */
    public static function img_replace($content)
    {
        $pattern = '/<img alt="YES[^>]*>/i';
        $replacement = '<i class="fas fa-check"></i>';
        $updated = preg_replace($pattern, $replacement, $content);
        $pattern = '/<img alt="NO[^>]*>/i';
        $replacement = '<i class="fas fa-times"></i>';
        return preg_replace($pattern, $replacement, $updated);
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

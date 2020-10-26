<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductCategories;
use App\ProductRating;
use App\ProductSubCategories;
use App\ProductUser;
use App\ProductVariation;
use App\SubCategory;
use App\User;
use Cloudder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $secondary_images;

    public function __construct()
    {
        $this->middleware('auth');
        $this->secondary_images = 5; // deprecated
        $this->num_images = 6;
        $this->num_tab_videos = 2;
        $this->num_tab_images = 8;
    }

    /**
     * Display a listing of the resource.
     * @todo this is just for the carousel right now. Extend to make other methods more DRY.
     * @return \Illuminate\Http\Response
     */
    private static function product_data($cat = false, $current = 0)
    {
        $user_id = \Auth::user()->id;
        $blocked_products = ProductUser::where('user_id', $user_id)->pluck('product_id')->toArray();

        if ($cat) {
            $products = Product::whereHas('categories', function ($query) use ($cat) {
                $query->where('category_id', $cat);
            })
                ->where('archived', 0)
                ->where('id', '!=', $current)
                ->whereNotIn('id', $blocked_products)
                ->orderBy('order', 'ASC')
                ->get();

        } else {
            $products = Product::where('archived', 0)
                ->where('id', '!=', $current)
                ->whereNotIn('id', $blocked_products)
                ->orderBy('order', 'ASC')
                ->get();
        }

        foreach ($products as $product) {
            if ($image_url = $product->img_url_1) {
                $match = null;
                preg_match('(\/STM\/.*)', $image_url, $match);
                $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 400, "height" => 400, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                $product->img_url_1 = $new_url;
            }
            $orig_cost = number_format($product->cost, 2);
            if ($product->discount) {
                $product->orig_price = $orig_cost;
                $product->cost_format = number_format($product->cost - ($product->cost * ($product->discount / 100)), 2);

            } else {
                $product->orig_price = null;
                $product->cost_format = $orig_cost;
            }
            $attributes_array = [];
            foreach ($product->attributes as $attribute) {
                if (count($attributes_array) < 4) {
                    $attributes_array[] = $attribute->text;
                }
            }
            $product->attributes_array = $attributes_array;

            // rating
            //$user_rating = ProductRating::where(['user_id' => $user_id, 'product_id' => $product->id])->first();

            $ratings = ProductRating::where('product_id', $product->id)->get();
            $stars_total = 0;
            foreach ($ratings as $rating) {
                $stars_total += $rating->stars;
            }
            if ($count = $ratings->count()) {
                $rating_calc = ($stars_total / $count);
            } else {
                $rating_calc = 0;
            }
            $product->rating = $rating_calc;
            $product->stock = $product->in_stock();
            $product->favorite = $product->is_favorite();
        }
        return $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$cats = Category::all();
        //dd($cats);
        $user_id = \Auth::user()->id;
        // $products = Product::join('product_categories', 'products.id', 'product_categories.product_id')
        //     ->where('products.archived', 0)
        //     ->orderBy('products.created_at', 'DESC')
        //     ->get();
        $blocked_products = ProductUser::where('user_id', $user_id)->pluck('product_id')->toArray();
        //dd($user_id);
        //dd($blocked_products);

        $products = Product::where('products.archived', 0)
            ->orderBy('order', 'ASC')
            ->whereNotIn('id', $blocked_products)
            ->get();

        foreach ($products as $product) {
            $product->img_url_1 = $product->get_cloudinary_thumbnail(600, 600);

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

            // rating
            // $user_rating = ProductRating::where(['user_id' => $user_id, 'product_id' => $product->id])->first();
            // if ($user_rating) {
            //     $product->rating = $user_rating->stars;
            // } else {
            $ratings = ProductRating::where('product_id', $product->id)->get();
            $stars_total = 0;
            foreach ($ratings as $rating) {
                $stars_total += $rating->stars;
            }
            if ($count = $ratings->count()) {
                $rating_calc = ($stars_total / $count);
            } else {
                $rating_calc = 0;
            }
            $product->rating = $rating_calc;
            $product->stock = $product->in_stock();
            $product->favorite = $product->is_favorite();
        }
        //dd($products);
        $sub_cat_match = [];
        $sub_cats = SubCategory::all();
        $sub_cats_array = [];
        foreach ($sub_cats as $sub_cat) {
            $sub_cat_match[$sub_cat->id] = $sub_cat->category_id;
            $sub_cats_array[] = $sub_cat->id;
        }
        $sub_cat_match = json_encode($sub_cat_match);
        $sub_cats_array = json_encode($sub_cats_array);

        $chosen_cat = intval($request->cat);

        $categories = Category::with('sub_categories')->get();
        return view('products.index', compact('categories', 'products', 'sub_cat_match', 'sub_cats_array', 'chosen_cat'));
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    function list() {
        return view('products.list');
    }

    /**
     * Display a listing of the resource for sorting
     *
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // $products = Product::orderBy('order', 'ASC')->get();
        // $count = 1;
        // foreach ($products as $product) {
        //     $product->order = $count++;
        //     $product->save();
        // }

        $categories = Category::all();
        $products = Product::orderBy('order', 'ASC')->get();
        $active = $request->cat;
        foreach ($products as $product) {
            $cat_class = '';
            foreach ($product->categories as $cat) {
                if ($cat->category_id == $active) {
                    $cat_class = 'active';
                }
            }
            $product->is_active = $cat_class;
        }
        return view('products.sort', compact('categories', 'products', 'active'));
    }

    // public function index_carousel()
    // {
    //     $products = self::product_data();
    //     return view('products.index-carousel', compact('products'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $num_images = $this->secondary_images;
        $tab_videos = $this->num_tab_videos;
        $tab_images = $this->num_tab_images;
        return view('products.create', compact('categories', 'num_images', 'tab_videos', 'tab_images'));
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
            'archived' => 'required',
        ], [
            'name.required' => 'Please enter a Name.',
            'cost.required' => 'Please enter a Cost.',
        ]);

        for ($i = 1; $i <= (1 + $this->secondary_images); $i++) {
            ${"image_upload_" . $i} = $request->file('upload-image-' . $i);
            if (${"image_upload_" . $i}) {
                $image_path = ${"image_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
                $result = $cloudinaryWrapper->getResult();
                ${"url_" . $i} = $result['secure_url'];
            } else {
                ${"url_" . $i} = '';
            }
        }

        for ($i = 1; $i <= (1 + $this->num_tab_videos); $i++) {
            ${"video_upload_" . $i} = $request->file('tab-upload-video-' . $i);
            if (${"video_upload_" . $i}) {
                $video_path = ${"video_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::uploadVideo($video_path, null, ['folder' => 'STM', 'timeout' => 300]);
                $result = $cloudinaryWrapper->getResult();
                ${"tab_url_video_" . $i} = $result['secure_url'];
            } elseif ($request->{"tab_video_url_" . $i}) {
                ${"tab_url_video_" . $i} = $request->{"tab_video_url_" . $i};
            } else {
                ${"tab_url_video_" . $i} = '';
            }
        }

        for ($i = 1; $i <= (1 + $this->num_tab_images); $i++) {
            ${"image_upload_" . $i} = $request->file('tab-upload-image-' . $i);
            if (${"image_upload_" . $i}) {
                $image_path = ${"image_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
                $result = $cloudinaryWrapper->getResult();
                ${"tab_url_" . $i} = $result['secure_url'];
            } elseif ($request->{"tab_img_url_" . $i}) {
                ${"tab_url_" . $i} = $request->{"tab_img_url_" . $i};
            } else {
                ${"tab_url_" . $i} = '';
            }
        }

        $available_on = null;
        if ($request->available_on) {
            $available_on = \Carbon\Carbon::parse($request->available_on)->format('Y-m-d');
        }

        $product = Product::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
            'description' => $request->description,
            'details' => self::img_replace($request->details),
            'more_details' => self::img_replace($request->more_details),
            'archived' => $request->archived,
            'available_on' => $available_on,
            'img_url_1' => $url_1,
            'img_url_2' => $url_2,
            'img_url_3' => $url_3,
            'img_url_4' => $url_4,
            'img_url_5' => $url_5,
            'img_url_6' => $url_6,
            'tab_video_url_1' => $tab_url_video_1,
            'tab_video_url_2' => $tab_url_video_2,
            'tab_img_url_1' => $tab_url_1,
            'tab_img_url_2' => $tab_url_2,
            'tab_img_url_3' => $tab_url_3,
            'tab_img_url_4' => $tab_url_4,
            'tab_img_url_5' => $tab_url_5,
            'tab_img_url_6' => $tab_url_6,
            'tab_img_url_7' => $tab_url_7,
            'tab_img_url_8' => $tab_url_8,
        ]);

        $product->update_order(1);

        // 1. Create new attributes
        foreach ($request->attribute_names as $attribute) {
            if ($attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'text' => $attribute,
                ]);
            }
        }

        // 2. Create new variations (colors)
        foreach ($request->variation_names as $variation) {
            if ($variation) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'text' => $variation,
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
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        //dd($product->first_variation());
        //$product->was_purchased();
        //dd($product->variations);
        //dd($product);
        $product->initial_quantity();
        for ($i = 1; $i <= $this->num_images; $i++) {
            if ($resource = $product->{"img_url_" . $i}) {
                if (strpos($resource, 'video') !== false) {
                    /**
                     * @todo I don't think this does anything - since this
                     * will only ever be images and not videos?
                     */
                    $new_url_small = str_replace('mp4', 'jpeg', $resource);
                    $product->{"img_url_small_" . $i} = $new_url_small;
                    //dd($new_url_small);
                } else {
                    $match = null;
                    preg_match('(\/STM\/.*)', $resource, $match);
                    $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 800, "height" => 800, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                    $product->{"img_url_" . $i} = $new_url;
                    $new_url_small = cloudinary_url($match[0], ["transformation" => ["width" => 300, "height" => 300, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                    $product->{"img_url_small_" . $i} = $new_url_small;
                }
            }
        }

        for ($i = 1; $i <= $this->num_tab_images; $i++) {
            if ($product->{"tab_img_url_" . $i}) {
                $match = null;
                preg_match('(\/STM\/.*)', $product->{"tab_img_url_" . $i}, $match);
                $new_url = cloudinary_url($match[0], ["transformation" => ["width" => 800, "height" => 800, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
                $product->{"tab_img_url_" . $i} = $new_url;
            }
        }

        for ($i = 1; $i <= $this->num_tab_videos; $i++) {
            if ($video_url = $product->{"tab_video_url_" . $i}) {
                $poster = str_replace('mp4', 'jpeg', $video_url);
                $product->{"tab_video_poster_" . $i} = $poster;
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

        $user_id = \Auth::user()->id;
        // $user_rating = ProductRating::where(['user_id' => $user_id, 'product_id' => $product->id])->first();
        // if ($user_rating) {
        $ratings = ProductRating::where('product_id', $product->id)->get();
        $stars_total = 0;
        foreach ($ratings as $rating) {
            $stars_total += $rating->stars;
        }
        if ($count = $ratings->count()) {
            $rating_calc = ($stars_total / $count);
        } else {
            $rating_calc = 0;
        }
        $product->rating = $rating_calc;

        $num_images = $this->num_images;
        $num_tab_images = $this->num_tab_images;
        $num_tab_videos = $this->num_tab_videos;
        // NUMBER CORRESPONDS TO CATEGORY ID
        $products = self::product_data(1, $product->id); // phones
        $products2 = self::product_data(2, $product->id); // tempered glass
        //$products3 = self::product_data(3); // power banks (cat deleted)
        $products4 = self::product_data(4, $product->id); // wall chargers
        $products6 = self::product_data(7, $product->id); // usb cables

        return view('products.show', compact(
            'product',
            'products',
            'products2',
            'products4',
            'products6',
            'num_images',
            'num_tab_images',
            'num_tab_videos'
        ));
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
        $tab_images = $this->num_tab_images;
        $tab_videos = $this->num_tab_videos;

        $users = User::getAgentsDealersActive();

        $blocked_users = ProductUser::where('product_id', $product->id)->get();

        return view('products.edit', compact(
            'product',
            'categories',
            'selected_cats',
            'selected_sub_cats',
            'num_images',
            'tab_images',
            'tab_videos',
            'users',
            'blocked_users'
        ));
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
            'archived' => 'required',
        ], [
            'name.required' => 'Please enter a Name.',
            'cost.required' => 'Please enter a Cost.',
        ]);

        for ($i = 1; $i <= (1 + $this->secondary_images); $i++) {
            ${"image_upload_" . $i} = $request->file('upload-image-' . $i);
            if (${"image_upload_" . $i}) {
                $image_path = ${"image_upload_" . $i}->getRealPath();
                // $mime_type = ${"image_upload_" . $i}->getMimeType();
                // if (strpos($mime_type, 'video') !== false) {}
                $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
                $result = $cloudinaryWrapper->getResult();
                ${"url_" . $i} = $result['secure_url'];
            } elseif ($request->{"img_url_" . $i}) {
                ${"url_" . $i} = $request->{"img_url_" . $i};
            } else {
                ${"url_" . $i} = '';
            }
        }

        for ($i = 1; $i <= (1 + $this->num_tab_videos); $i++) {
            ${"video_upload_" . $i} = $request->file('tab-upload-video-' . $i);
            if (${"video_upload_" . $i}) {
                $video_path = ${"video_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::uploadVideo($video_path, null, ['folder' => 'STM', 'timeout' => 300]);
                $result = $cloudinaryWrapper->getResult();
                ${"tab_url_video_" . $i} = $result['secure_url'];
            } elseif ($request->{"tab_video_url_" . $i}) {
                ${"tab_url_video_" . $i} = $request->{"tab_video_url_" . $i};
            } else {
                ${"tab_url_video_" . $i} = '';
            }
        }

        for ($i = 1; $i <= (1 + $this->num_tab_images); $i++) {
            ${"image_upload_" . $i} = $request->file('tab-upload-image-' . $i);
            if (${"image_upload_" . $i}) {
                $image_path = ${"image_upload_" . $i}->getRealPath();
                $cloudinaryWrapper = Cloudder::upload($image_path, null, ['folder' => 'STM']);
                $result = $cloudinaryWrapper->getResult();
                ${"tab_url_" . $i} = $result['secure_url'];
            } elseif ($request->{"tab_img_url_" . $i}) {
                ${"tab_url_" . $i} = $request->{"tab_img_url_" . $i};
            } else {
                ${"tab_url_" . $i} = '';
            }
        }

        $available_on = null;
        if ($request->available_on) {
            $available_on = \Carbon\Carbon::parse($request->available_on)->format('Y-m-d');
        }
        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'discount' => $request->discount,
            'description' => $request->description,
            'details' => self::img_replace($request->details),
            'more_details' => self::img_replace($request->more_details),
            'archived' => $request->archived,
            'available_on' => $available_on,
            //'quantity' => $request->quantity ? $request->quantity : 0,
            'img_url_1' => $url_1,
            'img_url_2' => $url_2,
            'img_url_3' => $url_3,
            'img_url_4' => $url_4,
            'img_url_5' => $url_5,
            'img_url_6' => $url_6,
            'tab_video_url_1' => $tab_url_video_1,
            'tab_video_url_2' => $tab_url_video_2,
            'tab_img_url_1' => $tab_url_1,
            'tab_img_url_2' => $tab_url_2,
            'tab_img_url_3' => $tab_url_3,
            'tab_img_url_4' => $tab_url_4,
            'tab_img_url_5' => $tab_url_5,
            'tab_img_url_6' => $tab_url_6,
            'tab_img_url_7' => $tab_url_7,
            'tab_img_url_8' => $tab_url_8,
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

        $temp_array = $request->variation_quantity;
        $combined = array_combine($request->variation_names, $request->variation_quantity);
        $colors_quantity = [];
        foreach ($combined as $key => $item) {
            if ($key) {
                $colors_quantity[$key] = $item;
            }
        }
        // 1. Delete existing variations for product
        ProductVariation::where('product_id', $product->id)->delete();

        // 2. Create new variations
        foreach ($colors_quantity as $text => $quantity) {
            if ($text) {
                if (!$quantity) {$quantity = 0;}
                ProductVariation::create([
                    'product_id' => $product->id,
                    'text' => $text,
                    'quantity' => $quantity,
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
        // 1. delete from product_categories
        $cats_delete = ProductCategories::where('product_id', $product->id)->delete();
        // 2. delete from product_sub_categories
        $sub_cats_delete = ProductSubCategories::where('product_id', $product->id)->delete();
        // 3. delete from product_ratings
        $ratings_delete = ProductRating::where('product_id', $product->id)->delete();
        // 4. delete from product_attributes
        $attributes_delete = ProductAttribute::where('product_id', $product->id)->delete();
        // 5. delete from product_variations
        $attributes_delete = ProductVariation::where('product_id', $product->id)->delete();
        // 5a change order
        $product->update_order_delete();
        // 6. finally, delete product
        $product->delete();
        // 7. flash and redirect
        session()->flash('message', 'Product Deleted');
        return redirect('/');
    }

    /**
     * /Dupicate the Product instance
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Product $product)
    {
        //\Log::debug('product duplicated NEW...');
        $new_id = $product->duplicate();
        return redirect('/products/edit/' . $new_id);
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

    public static function update_order(Request $request)
    {
        //$product->update_order($data->position);
        $product = Product::find($request->productId);
        $product->update_order($request->productIndex);
        //\Log::debug('new index ' . $request->productIndex . ' for product ' . $request->productId);
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

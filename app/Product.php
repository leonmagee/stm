<?php

namespace App;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * This is necessary because 'attributes' functions differently on $this...
     */
    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function first_variation()
    {
        $variation = $this->variations->where('quantity', '>', 0)->first();
        if ($variation) {
            return $variation->text;
        } else {
            return false;
        }
    }

    public function description_parsed()
    {
        $desc = strip_tags($this->description);
        $desc = preg_replace('/<[^>]*>/', ' ', $this->description);
        $length = strlen($desc);
        $max_length = 300;
        if ($length > $max_length) {
            $new_string = trim(substr($desc, 0, $max_length));
            $exploded = explode(' ', $new_string);
            array_pop($exploded);
            $new_string = implode(' ', $exploded);
            $last_char = substr($new_string, -1);
            if ($last_char == '.') {
                $new_string = substr($new_string, 0, -1);
            }
            return $new_string . '...';

        } else {
            return $desc;
        }
    }

    public function initial_quantity()
    {
        foreach ($this->variations as $variation) {
            if ($variation->quantity) {
                return $variation->quantity;
            }
        }
        return 0;
    }

    public function in_stock()
    {
        foreach ($this->variations as $variation) {
            if ($variation->quantity) {
                return true;
            }
        }
        return false;
    }

    public function is_favorite()
    {
        $user_id = \Auth::user()->id;
        $is_fav = ProductFavorite::where(['user_id' => $user_id, 'product_id' => $this->id])->first();
        if ($is_fav) {
            return true;
        }
        return false;
    }

    public function categories()
    {
        return $this->hasMany(ProductCategories::class);
    }

    // public function in_cat()
    // {
    //     return true;
    // }

    public function sub_categories()
    {
        return $this->hasMany(ProductSubCategories::class);
    }

    public function review()
    {
        $user_id = \Auth::user()->id;
        $review = ProductReview::where(['user_id' => $user_id, 'product_id' => $this->id])->first();
        return $review ? $review->review : '';
    }

    public function has_review()
    {
        $user_id = \Auth::user()->id;
        $review = ProductReview::where(['user_id' => $user_id, 'product_id' => $this->id])->first();
        if ($review) {
            return true;
        }
        return false;
    }

    public function was_purchased()
    {
        $user_id = \Auth::user()->id;
        $purchase = Purchase::join('purchase_products', 'purchases.id', '=', 'purchase_products.purchase_id')->where(['purchases.user_id' => $user_id, 'purchase_products.product_id' => $this->id])->first();
        if ($purchase) {
            return true;
        }
        return false;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function get_rating()
    {
        $ratings = ProductRating::where('product_id', $this->id)->get();
        $stars_total = 0;
        foreach ($ratings as $rating) {
            $stars_total += $rating->stars;
        }
        if ($count = $ratings->count()) {
            $rating_calc = ($stars_total / $count);
        } else {
            $rating_calc = 0;
        }
        return $rating_calc;
    }

    public function your_rating()
    {
        $user_id = \Auth::user()->id;
        $rating = ProductRating::where([
            'user_id' => $user_id,
            'product_id' => $this->id,
        ])->first();
        if (!$rating) {
            $final = 0;
        } else {
            $final = $rating->stars;
        }
        return $final;
    }

    public function discount_cost()
    {
        if ($this->discount) {
            return number_format($this->cost * ((100 - $this->discount) / 100), 2);
        }
        return number_format($this->cost, 2);
    }

    public function get_cloudinary_thumbnail($width, $height, $ext = false)
    {
        if ($image_url = $this->img_url_1) {
            $match = null;
            preg_match('(\/STM\/.*)', $image_url, $match);
            $new_url = cloudinary_url($match[0], ["transformation" => ["width" => $width, "height" => $height, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
            if ($ext) {
                $new_url = str_replace('.jpg', '.' . $ext, $new_url);
            }
            return $new_url;
        }
        return false;

    }

    public function update_order($order, $duplicate = false)
    {
        if (!$this->order || $duplicate) {
            $this->order = $order;
            $this->save();
            $products = Product::where('id', '!=', $this->id)
                ->where('order', '>=', $order)
                ->get();
            foreach ($products as $product) {
                $product->order++;
                $product->save();
            }
        } else {
            $existing_order = $this->order;
            $this->order = $order;
            $this->save();
            if ($order < $existing_order) {
                $products = Product::where('id', '!=', $this->id)
                    ->where('order', '>=', $order)
                    ->where('order', '<', $existing_order)
                    ->get();
                foreach ($products as $product) {
                    $product->order++;
                    $product->save();
                }
            } elseif ($order > $existing_order) {
                $products = Product::where('id', '!=', $this->id)
                    ->where('order', '>', $existing_order)
                    ->where('order', '<=', $order)
                    ->get();
                foreach ($products as $product) {
                    $product->order--;
                    $product->save();
                }

            }
        }

    }

    public function update_order_delete()
    {
        if ($this->order) {
            $products = Product::where('id', '!=', $this->id)
                ->where('order', '>=', $this->order)
                ->get();
            foreach ($products as $product) {
                $product->order--;
                $product->save();
            }
        }
    }

    public function duplicate()
    {
        $copy = $this->replicate();
        $categories = $this->categories;
        $copy->name = $copy->name . ' - COPY';
        $copy->archived = 1;
        $copy->push();
        $attributes = $this->product_attributes;
        if (count($attributes)) {
            foreach ($attributes as $item) {
                ProductAttribute::create([
                    'product_id' => $copy->id,
                    'text' => $item->text,
                ]);
            }
        }
        $categories = $this->categories;
        if (count($categories)) {
            foreach ($categories as $item) {
                ProductCategories::create([
                    'product_id' => $copy->id,
                    'category_id' => $item->category_id,
                ]);
            }
        }
        $sub_categories = $this->sub_categories;
        if (count($sub_categories)) {
            foreach ($sub_categories as $item) {
                ProductSubCategories::create([
                    'product_id' => $copy->id,
                    'sub_category_id' => $item->sub_category_id,
                ]);
            }
        }
        $variations = $this->variations;
        if (count($variations)) {
            foreach ($variations as $item) {
                ProductVariation::create([
                    'product_id' => $copy->id,
                    'text' => $item->text,
                    'quantity' => 0,
                ]);
            }
        }

        $copy->update_order(1, true);

        return $copy->id;
    }

    /**
     * @todo this won't work without upgrading to Laravel 5.7?
     */
    // public function saveQuietly()
    // {
    //     return static::withoutEvents(function () {
    //         return $this->save();
    //     });
    // }

    public function get_cats($needed, $sub_cat_final_array)
    {
        $cats = $this->categories()->first();
        $products_cats = ProductCategories::where('category_id', $cats->category_id)->get();

        if ($products_cats->count()) {

            $cats_array = [];
            foreach ($products_cats as $cat) {
                if ($cat->product_id !== $this->id) {
                    if (!in_array($cat->product_id, $sub_cat_final_array)) {
                        $product_check_cat = Product::find($cat->product_id);
                        if (!$product_check_cat->archived) {
                            $cats_array[] = $cat->product_id;
                        }
                    }
                }
            }
            $count = count($cats_array);

            $cat_final_array = array_slice($cats_array, 0, $needed);
        }

        return array_merge($sub_cat_final_array, $cat_final_array);

    }

    public function get_related()
    {
        $cats = $this->categories();
        $sub_cats = $this->sub_categories()->first();
        $sub_cat_final_array = [];
        $max_posts = 7;
        $needed = 0;
        $final_final_array = false;
        if ($sub_cats) {
            $products_sub_cats = ProductSubCategories::where('sub_category_id', $sub_cats->sub_category_id)->get();
            if ($products_sub_cats->count()) {
                $sub_cats_array = [];
                foreach ($products_sub_cats as $sub_cat) {
                    if ($sub_cat->product_id !== $this->id) {
                        $product_check = Product::find($sub_cat->product_id);
                        if (!$product_check->archived) {
                            $sub_cats_array[] = $sub_cat->product_id;
                        }
                    }
                }
                $count = count($sub_cats_array);
                if ($count > $max_posts) {
                    $sub_cat_final_array = array_slice($sub_cats_array, 0, $max_posts);
                } else {
                    $sub_cat_final_array = $sub_cats_array;
                }
            }
            // $current_count = count($sub_cat_final_array);
            // if ($current_count < $max_posts) {
            //     $needed = $max_posts - $current_count;
            //     $final_final_array = $this->get_cats($needed, $sub_cat_final_array);
            // } else {
            //     $final_final_array = $sub_cat_final_array;
            // }
            $final_final_array = $sub_cat_final_array;
        } else {
            //$final_final_array = $this->get_cats(3, []);
            $final_final_array = false;
        }

        if ($final_final_array) {
            $final_products = [];
            foreach ($final_final_array as $final_product) {
                $final_products[] = Product::find($final_product);
            }
            //$final_products = Product::whereIn('id', $final_final_array)->get();
        } else {
            $final_products = false;
        }
        return $final_products;
    }

}

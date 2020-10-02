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

    public function get_cloudinary_thumbnail($width, $height)
    {
        if ($image_url = $this->img_url_1) {
            $match = null;
            preg_match('(\/STM\/.*)', $image_url, $match);
            $new_url = cloudinary_url($match[0], ["transformation" => ["width" => $width, "height" => $height, "crop" => "fit"], "cloud_name" => "www-stmmax-com", "secure" => "true"]);
            return $new_url;
        }
        return false;

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

        return $copy->id;
    }

}

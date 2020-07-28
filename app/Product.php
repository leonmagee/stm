<?php

namespace App;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
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

}

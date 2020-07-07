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

    public function categories()
    {
        return $this->hasMany(ProductCategories::class);
    }

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
}

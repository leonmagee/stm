<?php

namespace App;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
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

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}

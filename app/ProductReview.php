<?php

namespace App;

class ProductReview extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rating()
    {
        $rating = ProductRating::where([
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
        ])->first();
        if (!$rating) {
            $final = 0;
        } else {
            $final = $rating->stars;
        }
        return $final;
    }
}

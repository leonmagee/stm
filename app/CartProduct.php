<?php

namespace App;

class CartProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function variation()
    // {
    //     return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    // }
}

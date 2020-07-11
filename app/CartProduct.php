<?php

namespace App;

class CartProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color_quantity($product_id, $variation)
    {
        $variation = ProductVariation::where(['product_id' => $product_id, 'text' => $variation])->first();
        if ($variation) {
            return $variation->quantity;
        }
        return 0;
    }

    // public function variation()
    // {
    //     return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    // }
}

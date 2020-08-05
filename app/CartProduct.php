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

    public function cart_variations()
    {
        $product_id = $this->product->id;
        $user_id = \Auth::user()->id;
        $cart_items = self::where(['product_id' => $product_id, 'user_id' => $user_id])->whereNotIn('id', [$this->id])->get();
        $chosen_variations = [];
        foreach ($cart_items as $item) {
            $chosen_variations[] = $item->variation;
        }
        $variations = $this->product->variations;
        $new_variations = [];
        foreach ($variations as $variation) {
            if ($variation->quantity > 0) {
                $text = $variation->text;
                if (!in_array($text, $chosen_variations)) {
                    $new_variations[] = $text;
                }
            }
        }
        return $new_variations;
    }
}

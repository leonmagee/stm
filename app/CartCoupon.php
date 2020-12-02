<?php

namespace App;

class CartCoupon extends Model
{
    public function coupon()
    {
        return $this::belongsTo(Coupon::class);
    }
}

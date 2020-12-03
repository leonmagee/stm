<?php

namespace App;

class Rma extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(PurchaseProduct::class, 'purchase_product_id');
    }

    public function notes()
    {
        return $this->hasMany(RmaNote::class)->orderBy('id', 'DESC');
    }

    public function discount_final_total()
    {
        $this->coupon_discount = $this->product->purchase->coupon_percent;
        $discounted_cost = $this->product->unit_cost * ((100 - ($this->product->discount)) / 100) * $this->quantity;
        if ($this->coupon_discount) {
            $discounted_cost = $discounted_cost * ((100 - ($this->coupon_discount)) / 100);
        }
        $this->discount_output = $this->product->discount ? $this->product->discount . '%' : '';
        $this->coupon_output = $this->coupon_discount ? $this->coupon_discount . '%' : '';
        $this->final_cost = $discounted_cost;
    }
}

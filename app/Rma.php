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
}

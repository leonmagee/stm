<?php

namespace App;

class Rma extends Model
{
    public function product()
    {
        return $this->belongsTo(PurchaseProduct::class, 'purchase_product_id');
    }
}

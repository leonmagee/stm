<?php

namespace App;

class PurchaseProduct extends Model
{
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function imeis()
    {
        return $this->hasMany(Imei::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

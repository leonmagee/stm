<?php

namespace App;

class Purchase extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function tracking_numbers()
    {
        return $this->hasMany(TrackingNumber::class);
    }
}

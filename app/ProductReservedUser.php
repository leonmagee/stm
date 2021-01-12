<?php

namespace App;

class ProductReservedUser extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

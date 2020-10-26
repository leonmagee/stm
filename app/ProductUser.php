<?php

namespace App;

class ProductUser extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

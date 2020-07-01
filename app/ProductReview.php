<?php

namespace App;

class ProductReview extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

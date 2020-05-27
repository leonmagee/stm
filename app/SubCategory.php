<?php

namespace App;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

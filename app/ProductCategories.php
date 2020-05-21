<?php

namespace App;

class ProductCategories extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

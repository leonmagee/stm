<?php

namespace App;

class ProductSubCategories extends Model
{
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
}

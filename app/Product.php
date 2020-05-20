<?php

namespace App;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategories::class);
    }

    public function sub_categories()
    {
        return $this->hasMany(ProductSubCategories::class);
    }
}

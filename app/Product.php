<?php

namespace App;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}

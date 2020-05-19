<?php

namespace App;

class Category extends Model
{
    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }
}

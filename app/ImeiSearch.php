<?php

namespace App;

class ImeiSearch extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

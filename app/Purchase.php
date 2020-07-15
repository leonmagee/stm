<?php

namespace App;

class Purchase extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

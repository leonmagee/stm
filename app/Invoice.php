<?php

namespace App;

class Invoice extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

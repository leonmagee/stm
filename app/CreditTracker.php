<?php

namespace App;

class CreditTracker extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

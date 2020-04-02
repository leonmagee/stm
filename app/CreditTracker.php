<?php

namespace App;

dd('deprecated');
class CreditTracker extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

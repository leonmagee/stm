<?php

namespace App;

class StoreCreditTracker extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin_user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

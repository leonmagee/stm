<?php

namespace App;

class UserLoginLogout extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

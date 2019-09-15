<?php

namespace App;

class Note extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

class Note extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function create()
    {
        // create new note...
        // user id / note text
    }
}

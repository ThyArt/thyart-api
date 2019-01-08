<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'name', 'address', 'phone'
    ];

    protected $hidden = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

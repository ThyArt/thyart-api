<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'country'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }
}

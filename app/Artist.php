<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['firstname', 'lastname', 'email', 'phone', 'address', 'city', 'country', 'user_id', /*todo remove*/];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

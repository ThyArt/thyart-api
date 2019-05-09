<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'artwork_id', 'date'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

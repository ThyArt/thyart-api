<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Artwork extends Model implements HasMedia
{
    use HasMediaTrait;
    const STATE_INCOMING = 'incoming';
    const STATE_SOLD = 'sold';
    const STATE_EXPOSED = 'exposed';
    const STATE_IN_STOCK = 'in_stock';
    protected $fillable = ['name', 'price', 'state', 'ref'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}

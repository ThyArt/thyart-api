<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Artwork
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $ref
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\Artist $artist
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereUserId($value)
 * @mixin \Eloquent
 */
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

    public function isAvailableForSold()
    {
        return $this->state == Artwork::STATE_EXPOSED || $this->state == Artwork::STATE_IN_STOCK;
    }
}

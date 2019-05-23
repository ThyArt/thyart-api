<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Gallery
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gallery whereUserId($value)
 * @mixin \Eloquent
 */
class Gallery extends Model
{
    protected $fillable = [
        'name', 'address', 'phone'
    ];

    protected $hidden = [
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }
}

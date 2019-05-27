<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Artist
 *
 * @property int $id
 * @property int $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artwork[] $artworks
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artist whereUserId($value)
 * @mixin \Eloquent
 */
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

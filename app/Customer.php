<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Customer
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property string $address
 * @property string $country
 * @property string $city
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereGalleryId($value)
 */
class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'country', 'city'
    ];

    protected $hidden = [
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function newsletters()
    {
        return $this->belongsToMany(Newsletter::class)->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}

<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Newsletter
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property string $address
 * @property string $country
 * @property string $city
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereGalleryId($value)
 */
class Newsletter extends Model
{
    protected $fillable = [
        'subject', 'description'
    ];

    protected $hidden = [
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withTimestamps();
    }

    public function artworks()
    {
        return $this->belongsToMany(Artwork::class)->withTimestamps();
    }
}

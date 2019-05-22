<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
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
    class Gallery extends \Eloquent
    {
    }
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property int $artwork_id
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereArtworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Artwork $artwork
 * @property-read \App\Customer $customer
 */
    class Order extends \Eloquent
    {
    }
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artist[] $artists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Artwork[] $artworks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Customer[] $customers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Gallery[] $galleries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 */
    class User extends \Eloquent
    {
    }
}

namespace App{
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUserId($value)
 */
    class Customer extends \Eloquent
    {
    }
}

namespace App{
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
    class Artist extends \Eloquent
    {
    }
}

namespace App{
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $media
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
    class Artwork extends \Eloquent
    {
    }
}

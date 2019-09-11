<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Artwork whereGalleryId($value)
 * @mixin \Eloquent
 * @property-read \App\Order $order
 */
class Artwork extends Model implements HasMedia
{
    use HasMediaTrait;
    const STATE_INCOMING = 'incoming';
    const STATE_SOLD = 'sold';
    const STATE_EXPOSED = 'exposed';
    const STATE_IN_STOCK = 'in_stock';

    protected $fillable = ['name', 'price', 'state', 'ref'];
    protected $diskStorage = [
        's3' => ['staging', 'production'],
        'public' => ['local', 'travis', 'testing']
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('small')
            ->width(128)
            ->height(128)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(256)
            ->height(256)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(512)
            ->height(512)
            ->nonQueued();

        $this->addMediaConversion('xlarge')
            ->width(1024)
            ->height(1024)
            ->nonQueued();
    }

    /**
     * @return string
     */
    private function getStorageByEnv()
    {
        foreach ($this->diskStorage as $key => $envs) {
            if (in_array(env('APP_ENV'), $envs)) {
                return $key;
            }
        }
        return 'local';
    }

    /**
     * @return BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * @return BelongsTo
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * @return HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * @return bool
     */
    public function isAvailableForSold()
    {
        return $this->state == Artwork::STATE_EXPOSED || $this->state == Artwork::STATE_IN_STOCK;
    }

    /**
     * @param string|UploadedFile $file
     * @return Artwork
     */
    public function storeImage($file)
    {
        $this
            ->addMedia($file)
            ->toMediaCollection('images', $this->getStorageByEnv());

        return $this;
    }
}

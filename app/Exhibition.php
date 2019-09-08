<?php


namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Exhibition
 *
 * @property int $id
 * @property string $name
 * @property Date $begin
 * @property Date $end
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exhibition whereGalleryId($value)
 */
class Exhibition extends Model
{
    protected $fillable = [
        'name', 'begin', 'end'
    ];

    protected $hidden = [
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
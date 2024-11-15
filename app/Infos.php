<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

/**
 * App\Infos
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string|null $description
 * @property string|null $link
 * @property string|null $type
 * @property string|null $datestart
 * @property string|null $dateend
 * @property int|null $duree
 * @property string|null $image
 * @property int $users_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Tags> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Infos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Infos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Infos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereDateend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereDatestart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Infos whereUsersId($value)
 * @mixin \Eloquent
 */
class Infos extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'status', 'user_id',"datestart","dateend"
    ];
    public function tags() {
        return $this->belongsToMany('App\Tags', 'infos_tags', 'infos_id', 'tags_id');
    }

    public function datestart ()  {
        return \Attribute::make(
            get: function($value) {
                $date = Carbon::parse($value);
                return $date->format('Y-m-d');
            },
            set: fn ($value) => $value,
        );
    }

    public function dateend ()  {
        return \Attribute::make(
            get: function($value) {
                $date = Carbon::parse($value);
                return $date->format('Y-m-d');
            },
            set: fn ($value) => $value,
        );
    }

    public function imageClass():BelongsTo
    {
        return $this->belongsTo(Image::class);
    }



}

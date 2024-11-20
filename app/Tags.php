<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tags
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Infos> $infos
 * @property-read int|null $infos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tags> $subs
 * @property-read int|null $subs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tags extends Model
{
    protected $fillable = [
        "title"
    ];
    public function posts() {
        return $this->belongsToMany('App\post', 'post_tags', 'tags_id', 'post_id');
    }

    public function infos() {
        return $this->belongsToMany('App\Infos', 'infos_tags', 'tags_id', 'infos_id');
    }

    public function subs()
    {
        return $this->hasMany(Tags::class);
    }
}

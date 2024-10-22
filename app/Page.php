<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Page
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $post
 * @property string|null $image
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $slug
 * @property int $status
 * @property string|null $type
 * @property int|null $post_id
 * @property int|null $tags_id
 * @property string|null $ip
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\post> $subs
 * @property-read int|null $subs_count
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereImage($value)
 * @method static Builder|Page whereIp($value)
 * @method static Builder|Page wherePost($value)
 * @method static Builder|Page wherePostId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereStatus($value)
 * @method static Builder|Page whereTagsId($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereType($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUserId($value)
 * @mixin \Eloquent
 */
class Page extends Model
{
    use HasFactory;
    use Rememberable;


    protected $table = 'post';

    protected static function booted()
    {
        static::addGlobalScope('page', function (Builder $builder) {
            $builder->where('type',config("app.typePost.page"));
        });
    }

    public function subs()
    {
        return $this->hasMany(post::class);
    }
}

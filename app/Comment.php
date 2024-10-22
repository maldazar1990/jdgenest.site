<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\post as post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Watson\Rememberable\Rememberable;

/**
 * App\Comment
 *
 * @property int $id
 * @property string|null $title
 * @property post|null $post
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, post> $subs
 * @property-read int|null $subs_count
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereImage($value)
 * @method static Builder|Comment whereIp($value)
 * @method static Builder|Comment wherePost($value)
 * @method static Builder|Comment wherePostId($value)
 * @method static Builder|Comment whereSlug($value)
 * @method static Builder|Comment whereStatus($value)
 * @method static Builder|Comment whereTagsId($value)
 * @method static Builder|Comment whereTitle($value)
 * @method static Builder|Comment whereType($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use Rememberable;

    use HasFactory;

    protected $table = 'post';
    protected $defaults = [

        "type"=>"comment",
    ];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    protected static function booted()
    {
        static::addGlobalScope('comment', function (Builder $builder) {
            $builder->where('type',"comment");
        });
    }

    public function post():BelongsTo
    {
        return $this->belongsTo(post::class,"post_id",'id');
    }

    public function subs():HasMany
    {
        return $this->hasMany(post::class,"post_id",'id');
    }
}

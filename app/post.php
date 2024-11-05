<?php

namespace App;

use App\Http\Helpers\HelperGeneral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Comment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Feed\Feed;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Watson\Rememberable\Rememberable;

/**
 * App\post
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, post> $subs
 * @property-read int|null $subs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Tags> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Users $user
 * @method static Builder|post newModelQuery()
 * @method static Builder|post newQuery()
 * @method static Builder|post query()
 * @method static Builder|post whereCreatedAt($value)
 * @method static Builder|post whereId($value)
 * @method static Builder|post whereImage($value)
 * @method static Builder|post whereIp($value)
 * @method static Builder|post wherePost($value)
 * @method static Builder|post wherePostId($value)
 * @method static Builder|post whereSlug($value)
 * @method static Builder|post whereStatus($value)
 * @method static Builder|post whereTagsId($value)
 * @method static Builder|post whereTitle($value)
 * @method static Builder|post whereType($value)
 * @method static Builder|post whereUpdatedAt($value)
 * @method static Builder|post whereUserId($value)
 * @mixin \Eloquent
 */
class post extends Model  implements Feedable
{
    use Rememberable;
    protected $table = "post";

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => HelperGeneral::getFirstWordFromText($this->post),
            'updated' => $this->updated_at,
            'link' => route("post",["slug" => $this->slug]),
            'authorName' => $this->user->name,
        ]);
    }

    public static function getFeedItems()
    {
        return post::limit(10)->orderBy('updated_at', 'desc')->get();
    }

    protected static function booted()
    {
        static::addGlobalScope('post', function (Builder $builder) {
            $builder->where('type',config("app.typePost.post"));
        });
    }

    public function tags():BelongsToMany {
        return $this->belongsToMany('App\Tags', 'post_tags', 'post_id', 'tags_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(Users::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,"post_id",'id');
    }

    public function subs(): HasMany
    {
        return $this->hasMany(post::class,"post_id",'id');
    }
}

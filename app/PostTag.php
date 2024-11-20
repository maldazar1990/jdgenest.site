<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\PostTag
 *
 * @property int $id
 * @property int $tags_id
 * @property int $post_id
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag whereTagsId($value)
 * @mixin \Eloquent
 */
class PostTag extends Model
{
    use HasFactory;
    protected $table = "post_tags";

}

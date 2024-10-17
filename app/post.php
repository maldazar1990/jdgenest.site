<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Comment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class post extends Model
{
    protected $table = "post";

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

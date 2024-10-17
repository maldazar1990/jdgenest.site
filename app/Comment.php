<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\post as post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
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

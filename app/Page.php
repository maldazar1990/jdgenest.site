<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

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

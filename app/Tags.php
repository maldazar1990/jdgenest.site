<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

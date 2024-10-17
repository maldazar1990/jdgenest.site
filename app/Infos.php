<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infos extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'status', 'user_id'
    ];
    public function tags() {
        return $this->belongsToMany('App\Tags', 'infos_tags', 'infos_id', 'tags_id');
    }
}

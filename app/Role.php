<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasName;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class);
    }
}

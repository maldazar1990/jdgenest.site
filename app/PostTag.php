<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class PostTag extends Model
{
    use HasFactory;
    use Rememberable;
    protected $table = "post_tags";

}

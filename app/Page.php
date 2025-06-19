<?php

namespace App;

use App\Http\Helpers\HelperGeneral;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\post as post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;


class Page extends Model
{

    use HasFactory;

    protected $table = 'Page';
    protected $defaults = [

        "type"=>"page",
    ];

    public function Page ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::decryptString(HelperGeneral::sanitize($value)),
            set: fn ($value) => Crypt::encryptString(HelperGeneral::sanitize($value)),
        );
    }

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

}

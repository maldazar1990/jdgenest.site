<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class options_table extends Model
{
    use HasFactory;
    protected $table = 'options_table';



    public function option_name ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::encryptString($value),
            set: fn ($value) => Crypt::decryptString($value),
        );
    }

    public function option_value ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::encryptString($value),
            set: fn ($value) => Crypt::decryptString($value),
        );
    }

    public function subs()
    {
        return $this->hasMany(options_table::class);
    }
}

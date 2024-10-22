<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * App\options_table
 *
 * @property int $id
 * @property string $option_name
 * @property string|null $option_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property int|null $options_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, options_table> $subs
 * @property-read int|null $subs_count
 * @method static \Illuminate\Database\Eloquent\Builder|options_table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|options_table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|options_table query()
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereOptionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereOptionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereOptionsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|options_table whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

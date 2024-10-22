<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\FirewallIp
 *
 * @property int $id
 * @property string $ip
 * @property int|null $log_id
 * @property int $blocked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp query()
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FirewallIp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FirewallIp extends Model
{
    use HasFactory;
    protected $table='firewall_ips';
    protected $fillable = ['ip'];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirewallIp extends Model
{
    use HasFactory;
    protected $table='firewall_ips';
    protected $fillable = ['ip'];

}

<?php

namespace App\Repository;

class FireWallRepository
{
    public static function getFireWallLogs()
    {
        return \App\FirewallLog::all();
    }

    public static function createReport( $ip, $level, $middleware )
    {
        $ip = \App\FirewallIp::firstOrCreate(['ip' => $ip]);
        $log = new \App\FirewallLog();
        $log->ip = $ip;
        $log->level = $level;
        $log->middleware = $middleware;
        $log->save();
        $ip->logs()->save($log);
    }
}
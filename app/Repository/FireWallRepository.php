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
        $ipModel = \App\FirewallIp::firstOrCreate(['ip' => $ip,"blocked"=>true]);
        $log = new \App\FirewallLog();
        $log->ip = $ip;
        $log->level = $level;
        $log->middleware = $middleware;
        $log->save();
        $ipModel->log_id = $log->id;
        $ipModel->save();
    }
}
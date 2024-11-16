<?php

namespace App\Http\Controllers;

use App\FirewallIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IpBanController extends Controller
{
    public function index()
    {
        return view('admin.index', [

            "title" => "Bannies",
            "liveWireTable" => "ban-table-view",
        ]);
    }

}

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

    public function destroy(Request $request, $id)
    {

        $bannies = FirewallIp::where( 'id', $id )->first();

        $bannies->delete();

        $request->session()->flash('message', "Supprimé avec succès");
        return redirect()->route('admin_ipban');
    }

    public function deleteAll(Request $request) {
        DB::statement('PRAGMA foreign_keys = OFF;');

        $request->session()->flash('message', "Supprimé avec succès");
        FirewallIp::delete();
        DB::statement('PRAGMA foreign_keys = ON;');

        return redirect()->route('admin_ipban');
    }
}

<?php

namespace App\Http\Controllers;

use App\Comment as Comment;
use App\FirewallIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class IpBanController extends Controller
{
    public function index()
    {
        $dataProvider = new EloquentDataProvider(FirewallIp::query());
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

<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Contact as Contact;
use App\FirewallIp;
use App\Tags as Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB as DB;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class MessageController extends Controller
{
    public function index()
    {
        $dataProvider = new EloquentDataProvider(Contact::query());
        return view('admin.index', [

            "title" => "Message",
            "liveWireTable" => "message-table-view",
        ]);
    }

    public function destroy(Request $request, $id)
    {

        $contact = Contact::where( 'id', $id )->first();

        $contact->delete();

        $request->session()->flash('message', "Enregistrer avec succès");
        return redirect()->route('admin_msg');
    }

    public function ban(Request $request, $id)
    {

        $contact = Contact::where( 'id', $id )->first();
        if(!empty(trim($contact->ip))) {
            FirewallIp::firstOrCreate([
                "ip" => $contact->ip
            ]);
        }

        $request->session()->flash('message', "ban");
        return redirect()->route('admin_msg');
    }

    public function deleteAll(Request $request) {
        DB::statement('PRAGMA foreign_keys = OFF;');

        $request->session()->flash('message', "Supprimé avec succès");
        DB::table("contact")->delete();
        DB::statement('PRAGMA foreign_keys = ON;');

        return redirect()->route('admin_comment');
    }
}

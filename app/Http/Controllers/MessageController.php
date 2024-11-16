<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Contact as Contact;
use App\FirewallIp;
use App\Repository\FireWallRepository;
use App\Tags as Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB as DB;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.index', [

            "title" => "Message",
            "liveWireTable" => "message-table-view",
        ]);
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::where( 'id', $id )->first();

        if (!$contact){
            return redirect()->route('admin_msg');
        }

        return view('admin.viewLivewire', [
            "model" => $contact,
        ]);
    }


}

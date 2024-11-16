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

    public function destroy(Request $request, $id)
    {

        $contact = Contact::where( 'id', $id )->first();

        if (!$contact){
            return redirect()->route('admin_msg');
        }

        $contact->delete();

        $request->session()->flash('message', "Enregistrer avec succès");
        return redirect()->route('admin_msg');
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

    public function ban(Request $request, $id)
    {

        $contact = Contact::where( 'id', $id )->first();

        if (!$contact){
            return redirect()->route('admin_msg');
        }

        if(!empty(trim($contact->ip))) {
            FireWallRepository::createReport($contact->ip, 2, "Bannie par l'administrateur");
        }

        $request->session()->flash('message', "ban");
        return redirect()->route('admin_msg');
    }

}

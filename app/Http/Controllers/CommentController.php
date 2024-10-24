<?php

namespace App\Http\Controllers;
use App\Comment as Comment;
use App\FirewallIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{
    public function index()
    {
        return view('admin.index', [

            "title" => "Commentaire",
            "liveWireTable" => "comment-table-view",
        ]);
    }

    public function ban(Request $request, $id)
    {

        $comment = Comment::where( 'id', $id )->first();

        if(!empty(trim($comment->ip))) {
            FirewallIp::firstOrCreate([
                "ip" => $comment->ip
            ]);
        }
        $request->session()->flash('message', "ban");
        return redirect()->route('admin_msg');
    }

    public function destroy(Request $request, $id)
    {

        $comment = Comment::where( 'id', $id )->first();
        Cache::forget("post_comments_".$comment->post_id);
    
        $comment->delete();
        
        $request->session()->flash('message', "Enregistrer avec succès");
        return redirect()->route('admin_comment');
    }

    public function deleteAll(Request $request) {
        DB::statement('PRAGMA foreign_keys = OFF;');
        $comments = Comment::where("type","comment")->get();
        foreach ($comments as $comment) {
            Cache::forget("post_comments_".$comment->post_id);
        }
        $request->session()->flash('message', "Supprimé avec succès");
        DB::table("post")->where("type","comment")->delete();
        DB::statement('PRAGMA foreign_keys = ON;');

        return redirect()->route('admin_comment');
    }
}

<?php

namespace App\Http\Controllers;
use App\Comment as Comment;
use App\FirewallIp;
use App\Repository\FireWallRepository;
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

    public function commentByPost($idPost)
    {
        dump($idPost);
        return view('admin.index', [

            "title" => "Commentaire",
            "liveWireTable" => "comment-table-view",
            "idPost" => $idPost
        ]);
    }
}

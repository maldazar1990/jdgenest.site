<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Jobs\SendEmailBasicJob;
use App\Repository\FireWallRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function rules (  ) {
        return [

            'savon' => "required|email:strict,dns|max:255|min:15",
            "text"=> "required | min:10|max:1024",

        ];
    }

    public function commentRules (  ) {
        return [
            "patate"=> "required | min:10| max:1024",
        ];
    }
    public function PostComment (Request $request) {
        if ($request->email) {
            FireWallRepository::createReport($request->ip(),2,"comment");

            return response()->json([
                'result'=>'error'
            ]);
        }
        $validator = Validator::make($request->all(), $this->commentRules(),[
            'patate.required' => 'Le champ est requis',
            'patate.min' => 'Le champ doit être supérieur à 3 caractères',
            'patate.max' => 'Le champ doit être inférieur à 1024 caractères',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result'=>$validator->errors()->toArray()
            ]);
        }
        $id = $request->id;
        $comment = new Comment();
        $comment->post = strip_tags($request->patate);
        $comment->user_id = 1;
        $comment->post_id = $id;
        $comment->ip = $request->ip();
        $comment->save();
        Cache::delete("post_comments_".$id);
        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un commentaire","mail.notif",''));

        return response()->json([
            'result'=>true
        ]);
    }

    public function GetComment (Request $request,$id) {
        $comments = Comment::where('post_id',$id)->get();
        return response()->json([
            'comments' => $comments->toArray()
        ]);
    }

    public function PostContact (Request $request) {
        if ($request->email or $request->name) {
            FireWallRepository::createReport($request->ip(),2,"contact");
            return response()->json([
                'result'=>'error'
            ]);
        }
        $validator = Validator::make($request->all(), $this->rules(),[
            'savon.required' => 'Le champ email est requis',
            'savon.email' => 'Le champ email doit être une adresse email valide',
            'savon.max' => 'Le champ email doit être inférieur à 255 caractères',
            'text.required' => 'Le champ message est requis',
            'text.min' => 'Le champ message doit être supérieur à 10 caractères',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result'=>false
            ]);
        }

        $contact = new Contact();
        $contact->name = Crypt::encryptString($request->name);
        $contact->email = Crypt::encryptString($request->savon);
        $contact->text = strip_tags($request->text);
        $contact->ip = $request->ip();
        $contact->save();
        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un message","mail.notif",''));

        return response()->json([
            'result'=>true
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Contact;
use App\FirewallIp;
use App\Http\Forms\ContactForm;
use App\Jobs\SendEmailBasicJob;
use App\options_table;
use App\post;
use App\Tags;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public array $options;
    public Users $userInfo;

    function __construct()
    {
        $this->options = options_table::all()->pluck('option_value', 'option_name')->toArray();
        $this->userInfo = Users::find(1)->first();
        setlocale(LC_TIME,'fr_FR');
    }

    function contact(Request $request,FormBuilder $formBuilder){
        $form = $formBuilder->create(ContactForm::class, [
            'method' => 'POST',
            'url' => route('send'),

        ]);
        return view('theme.blog.contact',[
            "form" => $form,
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            "title" => "Vous voulez me contacter ?",
            'message'=> "J'aime ma job mais si je peux vous répondre à des questions ou vous aider, je le ferai avec plaisir.",
            'SEOData' => new SEOData(
                title: "Vous voulez me contacter ?",
                description: "J'aime ma job mais si je peux vous répondre à des questions ou vous aider, je le ferai avec plaisir.",
                image: asset("images/".$this->userInfo->image."jpeg"),
                author: $this->userInfo->name,
                type: "article",
            ),
        ]);


    }

    function index(Request $request,$tagId = null){
        if ($tagId != null) {
            $posts = post::whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            })
            ->where(function($query) use ($request){
                $query->where("title",'like',"%".$request->search."%")
                    ->orWhere("post",'like',"%".$request->search."%");
            })
                ->where("post.status",0)
                ->orderBy('post.created_at', 'desc')->paginate(config("app.maxblog"));

        } else if ( $request->has('search') or $request->has('tags') ) {
            $validator = Validator::make($request->all(), [
                "search"=>"min:3 | max:20",
                "tags"=>"in:tags,id",
            ],[
                'search.min' => 'Le champ recherche doit être supérieur à 3 caractères',
                'search.max' => 'Le champ recherche doit être inférieur à 20 caractères',
                'tags.in' => 'Le champ tags doit être un nombre',
            ]);

            if ($validator->fails()) {
                return redirect()->back();
            }

            $posts = Post::where("title",'like',"%".$request->search."%")
            ->orWhere("post",'like',"%".$request->search."%")
            ->orderBy('post.created_at', 'desc')
            ->where("post.status",0)
            ->paginate(10);
        } else {
            $posts = Post::orderBy('created_at', 'desc')->where("post.status",0)->paginate(config("app.maxblog"));
        }
        $tags = Tags::whereIn("post_tags.post_id",$posts->pluck('id')->toArray())
            ->select("tags.id","tags.title")
            ->distinct()
            ->join("post_tags","post_tags.tags_id","=","tags.id")
            ->get();
        return view('theme.blog.home',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            'posts' => $posts,
            "tagId" => $tagId,
            "tags" => $tags,
            "title" => "Bienvenue sur mon blog",
            'message'=> "Voici mes derniers articles",
            'SEOData' => new SEOData(
                title: "Bienvenue sur mon blog",
                description: "Voici mes derniers articles",
                image: asset("images/".$this->userInfo->image),
                author: $this->userInfo->name,
                type: "article",
            ),
        ]);
    }

    function post(Request $request,$slug){

        if ( is_numeric($slug) )
            $post = Post::where("id",$slug)->first();
            
        else
            $post = Post::where("slug",$slug)->first();

        if ($post == null) {
            return redirect()->route('default');
        }

        $image = $post->image;
        $imagejpeg = explode('.',$image);
        $imagejpeg = $imagejpeg[0].".jpeg";

        if ( !file_exists(\public_path("images/").$imagejpeg) )
            $imagejpeg = $image;
        return view('theme.blog.post',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            'post' => $post,
            "comments" => $post->comments()->get(),
            'SEOData' => new SEOData(
                title: $post->title,
                description: Str::limit(strip_tags($post->post), 50),
                image: asset("images/".$imagejpeg),
                author: $post->user->name,
                type: "article",
            ),
        ]);
    }

    function about(Request $request){
        return view('theme.blog.about',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            "title" => "En résumé",
            "message" => $this->userInfo->presentation,
            'SEOData' => new SEOData(
                title:  "En résumé",
                description: $this->userInfo->presentation,
                image: asset("images/".$this->userInfo->image),
                author: $this->userInfo->name,
                type: "article",
            ),
        ]);
    }

    public function rules (  ) {
        return [

            'savon' => "required|email:strict,dns|max:255 ",
            "text"=> "required | min:10",
            "name" => "required | min:3",

        ];
    }

    public function commentRules (  ) {
        return [
            "patate"=> "required | min:10| max:255",
        ];
    }

    function send(Request $request){
        if ($request->email) {
            FirewallIp::firstOrCreate([
                "ip" => $request->ip()
            ]);
            abort(403);
        }
        $validator = Validator::make($request->all(), $this->rules(),[
            'savon.required' => 'Le champ email est requis',
            'savon.email' => 'Le champ email doit être une adresse email valide',
            'savon.max' => 'Le champ email doit être inférieur à 255 caractères',
            'text.required' => 'Le champ message est requis',
            'text.min' => 'Le champ message doit être supérieur à 10 caractères',
            'name.required' => 'Le champ nom est requis',
            'name.min' => 'Le champ nom doit être supérieur à 3 caractères',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contact = new Contact();
        $contact->name = Crypt::encryptString($request->name);
        $contact->email = Crypt::encryptString($request->savon);
        $contact->text = $request->text;
        $contact->ip = $request->ip();
        $contact->save();

        dd(env("MAIL_PERSO_EMAIL"));
        dispatch(new SendEmailBasicJob($request->savon,"Merci pour votre message","mail.email",''));
        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un message","mail.notif",''));

        $request->session()->flash('message', 'Ton message a été envoyé avec succès');
        return redirect()->route('contact');
    }

    function comment(Request $request,$id){

        if ($request->email) {
            FirewallIp::firstOrCreate([
                "ip" => $request->ip()
            ]);
            abort(403);
        }
        $validator = Validator::make($request->all(), $this->commentRules(),[
            'patate.required' => 'Le champ est requis',
            'patate.min' => 'Le champ doit être supérieur à 3 caractères',
            'patate.max' => 'Le champ doit être inférieur à 255 caractères',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comment = new Comment();
        $comment->post = $request->patate;
        $comment->user_id = 1;
        $comment->post_id = $id;
        $comment->ip = $request->ip();
        $comment->save();

        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un commentaire","mail.notif",''))->delay(60);

        return back()->with('message', 'Ton commentaire a été envoyé avec succès');
    }
}

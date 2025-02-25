<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Contact;
use App\FirewallIp;
use App\Http\Forms\ContactForm;
use App\Image;
use App\Jobs\SendEmailBasicJob;
use App\Mail\SendEmailBasic;
use App\options_table;
use App\post;
use App\Repository\FireWallRepository;
use App\Tags;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Hypertext\Transformer;

class PageController extends Controller
{
    public array $options;
    public Users $userInfo;

    function __construct()
    {
            
        if (Cache::has("optionsArray")) {
            $this->options = Cache::get("optionsArray");
        } else {
            $this->options = options_table::all()->pluck('option_value', 'option_name')->toArray();
            Cache::put("optionsArray",$this->options);
        }

        $this->userInfo =Cache::rememberForever('userInfo',function(){
            return Users::find(1)->first();
        });
  
        setlocale(LC_TIME,'fr_FR');
    }

    function contact(Request $request){

        return view('theme.blog.contact',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            "route" => route('send'),
            "title" => "Vous voulez me contacter ?",
            'message'=> "J'aime ma job mais si je peux vous répondre à des questions ou vous aider, je le ferai avec plaisir.",
            'SEOData' => new SEOData(
                title: "Vous voulez me contacter ?",
                description: "J'aime ma job mais si je peux vous répondre à des questions ou vous aider, je le ferai avec plaisir.",
                image: asset("images/".$this->userInfo->image."jpeg"),
                author: $this->userInfo->name,
                type: "website",
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
                ->where("created_at","<=",now())
                ->orderBy('post.created_at', 'desc')
                ->orderBy('post.id', 'desc')
                ->paginate(config("app.maxblog"));
           

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
            ->where("post.status",0)
            ->where("created_at","<=",now())
                ->orderBy('post.created_at', 'desc')
                ->orderBy('post.id', 'desc')

                ->paginate(config("app.maxblog"));
        } else {

            $page = $request->page;

            if($page == null){
                $page = 1;
            }

            $posts =  Cache::rememberForever('post_page_'.$page,function(){
                return Post::where("post.status",0)
                    ->where("created_at","<=",now())
                    ->orderBy('post.created_at', 'desc')
                    ->orderBy('post.id', 'desc')

                    ->paginate(config("app.maxblog"));
            });
        }

        if ( $posts == null ) {
            return redirect()->route('default');
        }

        $postsIds = $posts->pluck('id')->toArray();
        $tags =  Tags::whereIn("post_tags.post_id",$postsIds)
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
                description: "Découvrez le blog de Jean-Daniel Genest, développeur et expert en cybersécurité. Articles sur la technologie, la sécurité informatique et des récits personnels captivants",
                image: asset("images/".$this->userInfo->image),
                author: $this->userInfo->name,
                type: "website",
            ),
        ]);
    }

    function post(Request $request,$slug){

        if ( is_numeric($slug) ) {
            $post =  Cache::rememberForever("post_id_".$slug,function() use ($slug){
                return Post::where("id",$slug)->first();
            });
            
        }else {
  
            $post =  Cache::rememberForever("post_slug_".$slug,function() use ($slug){
                return Post::where("slug",$slug)->first();
            });
        }
            

        if ($post == null) {
            return redirect()->route('default');
        }

        $image = "";
        $isUrl = false;
        if ($post->image_id != null) {
            $images = $post->getImages();
            if($images != null){
                $image = $post->GetBasicImage();
                if($image == null){
                    $image = asset(config("custom.default"));
                } else {
                    $image = asset("/".$post->GetBasicImage());
                }

            } else {
                $image = asset(config("custom.default"));
            }
        } else {
            if(Str::isUrl($post->image_url)){
                $isUrl = true;
                $image = $post->image_url;
            }
        }

        $comments = Cache::rememberForever("post_comments_".$post->id,function() use ($post){
            return $post->comments()->get();
        });

        $transformer = new Transformer();
        $description = $transformer->toText($post->post);

        $ogimage = false;
        if ($isUrl) {
            $image = $image;
        } else {
            $localImage = public_path($post->GetBasicImage());
            if(\file_exists($localImage)) {
                $imageSize = getimagesize($localImage);
                $ogimage = [
                    'og:image:type' => mime_content_type($localImage),
                    'og:image:width' => $imageSize[0],
                    'og:image:height' => $imageSize[1],
                    'og:image:alt' =>  asset(config("custom.default"))

                ];
            }
            
        }

        return view('theme.blog.post',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            'post' => $post,
            "comments" => $comments,
            "ogData" => $ogimage,
            "otherPosts" => \App\Post::select("post.*")
            ->join("post_tags","post_tags.post_id","=","post.id")
            ->join("tags","tags.id","=","post_tags.tags_id")
            ->whereIn('tags.id',function($q) use ($post) {
                $q->select("tags.id")
                ->from("tags")
                ->join("post_tags","post_tags.tags_id","=","tags.id")
                ->where("post_tags.post_id","=",$post->id);
            })
            ->where("post.status",0)
            ->where("post.id","!=",$post->id)
            ->inRandomOrder()
            ->limit(2)
            ->get(),
            
            'SEOData' => new SEOData(
                title: $post->title,
                description: Str::limit($description , 160),
                image: $image,
                author: $post->user->name,
                type: "article",
            ),
        ]);
    }

    function about(Request $request){
        $userInfo = $this->userInfo;
        $infos = Cache::rememberForever("infos",function() use ($userInfo){
            return$userInfo->infos()->where("type","info")->get();
        });
        $exps = Cache::rememberForever("exps",function() use ($userInfo){
            return $userInfo->infos()->where("type","exp")->orderBy('datestart', 'desc')->get();
        });
        $otherExps = Cache::rememberForever("otherExp",function() use ($userInfo){
            return $userInfo->infos()->where("type","!=","exp")->orderBy('datestart', 'desc')->get();
        });
        return view('theme.blog.about',[
            'options' => $this->options,
            'userInfo' => $this->userInfo,
            "title" => "En résumé",
            "message" => $this->userInfo->presentation,
            'infos'=> $infos,
            "otherExps" => $otherExps,
            "exps" => $exps,
            'SEOData' => new SEOData(
                title:  "En résumé",
                description: "Le blog de Jean-Daniel Genest, développeur et expert en cybersécurité. Articles sur la technologie, la sécurité et des récits personnels captivants. Rejoignez-nous pour des discussions enrichissantes.",
                image: asset("images/".$this->userInfo->image),
                author: $this->userInfo->name,
                type: "website",
                
            ),
        ]);
    }

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

    function send(Request $request){
        if ($request->email or $request->name) {
            FireWallRepository::createReport($request->ip(),2,"contact");
            abort(403);
        }
        $validator = Validator::make($request->all(), $this->rules(),[
            'savon.required' => 'Le champ email est requis',
            'savon.email' => 'Le champ email doit être une adresse email valide',
            'savon.max' => 'Le champ email doit être inférieur à 255 caractères',
            'text.required' => 'Le champ message est requis',
            'text.min' => 'Le champ message doit être supérieur à 10 caractères',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contact = new Contact();
        $contact->name = Crypt::encryptString($request->name);
        $contact->email = Crypt::encryptString($request->savon);
        $contact->text = strip_tags($request->text);
        $contact->ip = $request->ip();
        $contact->save();
        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un message","mail.notif",''));

        $request->session()->flash('message', 'Ton message a été envoyé avec succès');
        return redirect()->route('contact');
    }

    function comment(Request $request,$id){

        if ($request->email) {
            FireWallRepository::createReport($request->ip(),2,"comment");

            abort(403);
        }
        $validator = Validator::make($request->all(), $this->commentRules(),[
            'patate.required' => 'Le champ est requis',
            'patate.min' => 'Le champ doit être supérieur à 3 caractères',
            'patate.max' => 'Le champ doit être inférieur à 1024 caractères',
        ]);
        if ($validator->fails()) {
            return Redirect::route('post',post::find($id)->slug)->withErrors($validator)->withInput();
        }

        $comment = new Comment();
        $comment->post = strip_tags($request->patate);
        $comment->user_id = 1;
        $comment->post_id = $id;
        $comment->ip = $request->ip();
        $comment->save();
        Cache::delete("post_comments_".$id);
        dispatch(new SendEmailBasicJob(env("MAIL_PERSO_EMAIL"),"Fuck un commentaire","mail.notif",''));

        return Redirect::to(route('post',post::find($id)->slug)."#comment");
    }


}

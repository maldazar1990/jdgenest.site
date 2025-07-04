<?php

namespace App\Http\Controllers;

use App\Http\Forms\PostForm;
use App\Http\Helpers\HelperGeneral;
use App\Image;
use App\Jobs\ConvertImage;
use App\Jobs\SiteMapGoogle;
use App\post;
use App\Tags;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Helpers\Image as HelpersImage;

class AdminPageController extends Controller
{
    use TitleIsUnique;
    public function index()
    {
        return view('admin.index', [

            "title" => "Articles",
            "liveWireTable" => "post-table-view",
        ]);
    }

    /**
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request) {

        $tags = Tags::all();
        $selectedTags = [];
        if(old("tags")){
            $selectedTags = old("tags");
        } 

        return view("admin.editPost",[
            "title" => "Publier un article",
            "model"=> null,
            "route" => route("admin_posts_insert"),
            "selectedTags" => $selectedTags,
            "tags" => $tags,
        ]);
    }

    public function rules ( $isUpdate = false ) {
        $rules = array(

            'title' => "required|max:70",

            "post" => "required|min:1000",
            "tags" => "required",
            "status"=>"required|in:0,1,2",
            "created_at" => "date|required",

        );

        if ($isUpdate){
            $rules["image"] = config("app.rule_image");
        } else {
            $rules["image"] = "required|".config("custom.rulesImage");
        }

        return $rules;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules(isset($request->imageid));
        $rules["title"] = $rules["title"] . "|unique:post,title";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('admin_posts_create')
                ->withErrors($validator)
                ->withInput();
        }
        $post = new post();

        $this->saveImage($request,$post);

        $post->title = $request->input("title");
        $post->post = $request->input("post");
        $post->slug = Str::slug($post->title,"-");
        $post->status = $request->input("status");
        $post->user_id = Auth::user()->id;
        $post->created_at = $request->input("created_at");
        $post->type = config("app.typePost.post");
        $post->save();
        $tagsIds = $request->input("tags");
        $post->tags()->detach();
        if( $tagsIds ) {
            foreach($tagsIds as $tagsId) {
                if ( !is_numeric($tagsId) ) {
                    $tag = new Tags;

                    $tag->title = $tagsId;
                    $tag->save();
                } else {
                    $tag = Tags::find($tagsId);
                }
                $post->tags()->attach($tag);
            }
        }
        Cache::flush();
        return redirect()->route('admin_posts_edit', $post->id)->with('message','Enregistré avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $posts = post::where( 'id', $id )->first();

        if ( !$posts )
            return redirect()->route("admin_posts");

        $typeImage = 2;
        $image = "";

        if ( $posts->imageClass() ) {
            if (Str::contains($posts->imageClass->file, 'images/')) {
                $image = asset($posts->imageClass->file);
            } else {
                $image = asset("images/" . $posts->imageClass->file);
            }

            $typeImage = 1;
        } else if ( Str::isUrl($posts->image) ) {
            if (HelperGeneral::urlValide($posts->image)) {
                $image = $posts->image;
            }

            $typeImage = 0;
        } else {
            $image = asset("images/" .$posts->image);
            $typeImage = 1;
        }

        $tags = Tags::all();
        $selectedTags = [];
        if(old("tags")){
            $selectedTags = old("tags");
        } else if($posts){
            $selectedTags = $posts->tags->pluck("id")->toArray();
        }


        return view("admin.editPost",[
            "title" => "Modifier une publication",
            "model" => $posts,
            "selectedTags" => $selectedTags,
            "typeImage" => $typeImage,
            "route" => route("admin_posts_update", $id),
            "image" => $image,
            "tags" => $tags,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $post = post::where( 'id', $id )->first();

        if (!$post) {
            return redirect()->route('admin_posts');
        }

        $validator = Validator::make($request->all(), $this->rules(true));
        
        if ($validator->fails()) {
            return redirect()->route('admin_posts_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        $this->saveImage($request,$post);
        $post->title = $request->input("title");
        $post->post = $request->input("post");
        $post->status = $request->input("status");
        $post->slug = Str::slug($post->title,"-");
        $post->created_at = $request->input("created_at");
        $post->save();
        $tagsIds = $request->input("tags");
        $post->tags()->detach();
        if( $tagsIds ) {
            foreach($tagsIds as $tagsId) {

                if ( !is_numeric($tagsId) ) {
                    $tag = new Tags;

                    $tag->title = $tagsId;
                    $tag->save();
                } else {
                    $tag = Tags::find($tagsId);
                }

                $post->tags()->attach($tag);

            }
        }

        Cache::flush();
        return redirect()->route('admin_posts_edit', $post->id)->with('message','Sauvegardé avec succès');

    }

    protected function saveImage (Request $request, post $post):Image|null
    {
        $Imageobj = new Image();

        if ($request->file("image")) {
            $Imageobj = \App\Http\Helpers\Image::saveNewImage($request, $post);

        } elseif ($request->imageUrl) {
            if ($post->image) {
                $img = new HelpersImage($post->image);
                $img->deleteImage();
            }
            $post->image = $request->imageUrl;
            $post->image_id = null;
            return null;
        } else if($request->imageid) {
            $Imageobj = Image::find($request->imageid);
            $post->image = $Imageobj->file;
            $post->image_id = $Imageobj->id;
        } else {
            return null;
        }
        return $Imageobj;
    }

    public function ajax(Request $request,$title) {

        if ($request->ajax()) {

            $posts = post::distinct()
                ->select("post.id as id","post.slug","post.title")
                ->where("title","LIKE","%".HelperGeneral::clean($title)."%")
                ->where("status","!=",2)
                ->offset(0)->limit(5)
                ->get()->toArray();

            foreach  ( $posts as &$post ) {
                $post["link"] =route("post", $post['slug']);
                $post["value"] = $post["title"];
                unset($post["slug"]);
                unset($post["title"]);
                
            }

            return response()->json($posts);
        } else {
            abort(404);
        }
    }

    public function isUnique(Request $request) {

        if($request->ajax()){
            return response()->json($this->isTitleUnique($request,new post()));
        }
        abort(404);
    }
    
}

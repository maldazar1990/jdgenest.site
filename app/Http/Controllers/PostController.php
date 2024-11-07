<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\PostForm;
use App\Http\Helpers\Image as HelpersImage;
use App\Image;
use App\Jobs\ConvertImage;
use App\post;
use App\Tags;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;

class PostController extends Controller
{
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
    public function create(Request $request, FormBuilder $formBuilder) {
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route("admin_posts_insert"),
        ]);

        
        

        $tags = Tags::all();
        $selectedTags = [];
        if(old("tags")){
            $selectedTags = old("tags");
        } 

        return view("admin.editPost",[
            "title" => "Publier un article",
            "form"  => $form,
            "selectedTags" => $selectedTags,
            "tags" => $tags,
        ]);
    }

    public function rules ( $isUpdate = false ) {
        $rules = array(

            'title' => "required|max:255",

            "post" => "required",
            "tags" => "required",
            "status"=>"required|in:0,1,2",

        );

        if ($isUpdate){
            $rules["images"] = config("app.rule_image");
        } else {
            $rules["images"] = "required|".config("app.rule_image");
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
        
        $rules = $this->rules();
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
    public function edit(Request $request, FormBuilder $formBuilder, $id)
    {
        $posts = post::where( 'id', $id )->first();
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route('admin_posts_update', $id),
            'model' => $posts,
        ]);

        $typeImage = 2;
        $image = "";
        if ($posts->image) {

            if (Str::contains($posts->image, 'http')) {

                if (HelperGeneral::urlValide($posts->image)) {
                    $image = $posts->image;
                } 
                
                $typeImage = 0;
            } else {
                
                if ($posts->image_id)  {
                    $dbImage = Image::where("id",$posts->image_id)->first();
                    if ($dbImage) {
                        
                        if (Str::contains($dbImage->file, 'images/')) {
                            $image = asset($dbImage->file);
                        } else {
                            $image = asset("images/" . $dbImage->file);
                        }

                        $typeImage = 1;
                    } else {
                        $image = asset("images/" . $dbImage->file);
                        $typeImage = 1;
                    }
                } else {
                    if (Str::contains($posts->image, 'images/')) {
                        $image = asset($posts->image);
                    } else {
                        $image = asset("images/" .$posts->image);
                    }
                    $typeImage = 2;
                }
            }
                
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
            "form" => $form,
            "model" => $posts,
            "selectedTags" => $selectedTags,
            "typeImage" => $typeImage,
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

    protected function saveImage (Request $request, post $post):Image|null {
        $Imageobj = new Image();
        if ( $request->file("image")  ) {
           $Imageobj = \App\Http\Helpers\Image::saveNewImage($request, $post);
 
        } elseif($request->imageUrl) {
            if ($post->image) {
                $img = new HelpersImage($post->image);
                $img->deleteImage();
            }
            $post->image = $request->imageUrl;
            $post->image_id = null;
            return null;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $posts = post::where( 'id', $id )->first();
        $posts->status = 2;
        if ( Cache::has('post_id_'.$posts->id) )
            Cache::forget('post_id_'.$posts->id);
        if ( Cache::has('post_slug_'.$posts->slug) )
            Cache::forget('post_slug_'.$posts->slug);
        Cache::forget('allPosts');
        $posts->save();
	return redirect()->route('admin_posts');

    }
}

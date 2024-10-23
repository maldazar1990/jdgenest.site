<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\PostForm;
use App\Jobs\ConvertImage;
use App\post;
use App\Tags;
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

        return view("admin.editWithImage",[
            "title" => "Publier un article",
            "form"  => $form,
        ]);
    }

    public function rules (  ) {
        return array(

            'title' => "required|max:255",
            "image" => config("app.rule_image"),
            "post" => "required",
            "tags" => "required",
            "status"=>"required|in:0,1,2",

        );
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

        if ( $request->file("image") ) {
            $file = $request->file("image");
            $name = Str::slug(time() . $file->getClientOriginalName());
            $file->move(public_path("images/"), $name);
            \dispatch(new ConvertImage($name,$post->id));
            $post->image = $name;
        } else  if ( $request->imageUrl ) {
            HelperGeneral::deleteImage($post->image);
            $post->image = $request->imageUrl;
        } else if ( $request->selectImage ) {
            $post->image = $request->selectImage.".webp";
        }

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


        return view("admin.editWithImage",[
            "title" => "Modifier une publication",
            "form" => $form,
            "model" => $posts,
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
        $validator = Validator::make($request->all(), $this->rules());
        
        if ($validator->fails()) {
            return redirect()->route('admin_posts_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        if ( $request->hiddenTypeImage == "upload" or $request->file("image")  ) {
            HelperGeneral::deleteImage($post->image);
            $file = $request->file("image");
            $name = Str::slug(time() . $file->getClientOriginalName()).".".$file->getClientOriginalExtension();
            $file->move(\public_path("images/"), $name);
            \dispatch(new ConvertImage($name,$post->id));
            $post->image = $name;
 
        } else if ( $request->hiddenTypeImage == "url" or $request->imageUrl  ) {
            HelperGeneral::deleteImage($post->image);
            $post->image = $request->imageUrl;
        } else if ( $request->hiddenTypeImage == "select" or $request->selectImage  ) {
            $post->image = $request->selectImage.".webp";
        }
        
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

        return redirect()->route('admin_posts_edit', $post->id)->with('message','Sauvegardé avec succès');

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
        $posts->save();
	return redirect()->route('admin_posts');

    }
}

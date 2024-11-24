<?php

namespace App\Http\Controllers;

use App\Http\Forms\TagForm;
use App\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    use TitleIsUnique;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [

            "title" => "Tags",
            "liveWireTable" => "tag-table-view",
        ]);
    }

    /**
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create_tags(Request $request) {

        return view("admin.editTag",[
            "title" => "Créer un tag",
            "model"  => null,
            "route"=>"/admin/tags/insert"
        ]);
    }

    public function ajax(Request $request) {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'term' => 'required|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            } else {
                $tags["results"] = DB::table("tags")->distinct()
                    ->select("tags.id as id","tags.title as text")
                    ->where("title","LIKE","%".\App\Http\Helpers\HelperGeneral::sanitize($request->term)."%")
                    ->get()->toArray();
                return response()->json($tags);
            }
        } else {
            abort(404);
        }
    }

    public function rules (  ) {
        return [

            'title' => "required|max:255 |unique:tags,title",

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('admin_tags_create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $tags = new Tags;
        $tags->title = $request->input("title");
        $tags->save();
        Cache::forget('tags');
        $request->session()->flash('success', 'Enregistrer avec succès');
        return redirect()->route('admin_tags');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $tags = Tags::where( 'id', $id )->first();

        if ( !$tags ) {
            return redirect()->route('admin_tags');
        }


        return view("admin.editTag",[
            "title" => "Modifier un tag",
            'model' => $tags,
            "route"=>route('admin_tags_update', $id)
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

        $tags = Tags::where( 'id', $id )->first();

        if (!$tags) {
            return redirect()->route('admin_tags');
        }

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('admin_tags_edit', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $tags->title = $request->input("title");
        foreach ($tags->posts()->get() as $post) {
            Cache::forget('tags_post_'.$post->id);
        }
        Cache::forget('tags');
        $tags->save();
        $request->session()->flash('message', 'Enregistrer avec succès');
        return redirect()->route('admin_tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $tags = Tags::where( 'id', $id )->first();

        if (!$tags) {
            return redirect()->route('admin_tags');
        }

        if ($tags->posts()->count() > 0 or $tags->infos()->count() > 0) {
            $request->session()->flash('error', 'Impossible de supprimer ce tag, il est utilisé');
            return redirect()->route('admin_tags');
        } else {
            foreach ($tags->posts()->get() as $post) {
                Cache::forget('tags_post_'.$post->id);
            }
    
            Cache::forget('tags');
            $tags->delete();

            $request->session()->flash('message', "Enregistrer avec succès");
            return redirect()->route('admin_tags');
        }

    }

    public function isUnique(Request $request) {

        if($request->ajax()){
            return response()->json($this->isTitleUnique($request,new Tags()));
        }
        abort(404);
    }
}


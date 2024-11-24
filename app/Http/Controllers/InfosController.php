<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\infosForm;
use App\Http\Helpers\Image;
use App\Http\Helpers\ImageConverter;
use App\Infos;
use App\Jobs\ConvertImage;
use App\post;
use Illuminate\Http\Request;
use App\Tags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InfosController extends Controller
{   
    private $tags;
    use TitleIsUnique;

    public function __construct()
    {
        $this->tags = Tags::all();
    }
    public function index()
    {
        return view('admin.index', [
            "title" => "Information",
            "liveWireTable" => "info-table-view",
        ]);
    }

    public function isUnique(Request $request) {

        return $this->isUnique($request, Infos::class);
    }

    public function create(Request $request)
    {


        return view('admin.editInfo', [
            'title' => "Ajouter une information",
            'info' => null,
            'tags' => $this->tags,
            "route" => route("admin_infos_insert"),
        ]);
    }


    public function rules( $haveDateEnd = false )
    {

        if ( $haveDateEnd )
            $rules["dateend"] = "date|after:datestart";


        $rules = [

            'title' => "required|max:255",
            'description' => "required",
            'link' => "required|max:255|url",
            "datestart" => "date",
            "duree" => "min:0 | max:40",

            "image" => "required|".config("custom.rulesImage"),
            "type" => "required|in:exp,job,school",

        ];

        return $rules;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules($request->exists("dateend")));

        if ($validator->fails()) {
            return redirect()->route("admin_infos_create")
                ->withErrors($validator)
                ->withInput();
        }

        $infos = new Infos();

        Image::saveNewImage($request, $infos);
        $infos->title = $request->input("title");
        $infos->description = $request->input("description");
        $infos->link = $request->input("link");
        $infos->type = $request->input("type");
        $infos->datestart = $request->input("datestart");
        $infos->dateend = $request->input("dateend");
        $infos->duree = $request->input("duree");
        $infos->users_id = Auth::user()->id;
        $infos->save();
        $tagsIds = $request->input("tags");
        Cache::forget("exps");
        Cache::forget("otherExp");
        Cache::forget("infos");
        $infos->tags()->detach();
        if( $tagsIds ) {
            foreach($tagsIds as $tagsId) {
                if ( !is_numeric($tagsId) ) {
                    $tag = new Tags;

                    $tag->title = $tagsId;
                    $tag->save();
                } else {
                    $tag = Tags::find($tagsId);
                }
                $infos->tags()->attach($tag);
            }
        }
        $request->session()->flash('message', 'Enregistrement effectué avec succès');
        return redirect()->route('admin_infos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Groups $groups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $info = Infos::where('id', $id)->first();

        if (!$info) {
            return redirect()->route("admin_infos");
        }

        return view("admin.editInfo", [
            "title" => "Modifier une information",
            "route" => route("admin_infos_update", $id),
            "tags" => $this->tags,
            "info" => $info,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Groups $groups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), $this->rules($request->exists("dateend")));
        $infos = Infos::where('id', $id)->first();

        if  ( !$infos ) {
            return redirect()->route('admin_infos');
        }

        if ($validator->fails()) {
            return redirect()->route("admin_infos_edit", $id)
                ->withErrors($validator)
                ->withInput();
        }

        Image::saveNewImage($request, $infos);
        $infos->title = $request->input("title");
        $infos->description = $request->input("description");
        $infos->link = $request->input("link");
        $infos->type = $request->input("type");
        $infos->datestart = $request->input("datestart");
        $infos->dateend = $request->input("dateend");
        $infos->duree = $request->input("duree");
        $infos->users_id = Auth::user()->id;
        $infos->save();
        $infos->tags()->detach();
        $tagsIds = $request->tags;
        Cache::forget("exps");
        Cache::forget("otherExp");
        Cache::forget("infos");

        if( $tagsIds ) {
            foreach($tagsIds as $tagsId) {

                $infos->tags()->attach(Tags::find($tagsId));
            }
        }
        $request->session()->flash('message', 'Enregistrement effectué avec succès');
        return redirect()->route('admin_infos');

    }


}

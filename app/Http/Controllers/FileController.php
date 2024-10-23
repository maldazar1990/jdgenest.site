<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\FileForm;
use App\Http\Forms\TagForm;
use App\Image;
use App\Tags as Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        return view('admin.index', [

            "title" => "Images",
            "liveWireTable" => "image-grid-view",
        ]);
    }

    /**
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, FormBuilder $formBuilder) {
        $form = $formBuilder->create(FileForm::class, [
            'method' => 'POST',
            'url' => route('admin_files_store'),
        ]);

        return view("admin.edit",[
            "title" => "Ajouter une image",
            "form"  => $form,
        ]);
    }

    public function ajax(Request $request) {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'term' => 'max:10',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            } else {
                $tags["results"] = Image::distinct()
                    ->select("id as id","file as text", "name")
                    ->where("title","LIKE","%".HelperGeneral::clean($request->term)."%")
                    ->orWhere("file","LIKE","%".HelperGeneral::clean($request->term)."%")
                    ->get()->toArray();
                return response()->json($tags);
            }
        } else {
            abort(404);
        }
    }


    function store (Request $request) {
        $request->validate([
            'image' => 'required|'.config("app.rule_image"),
            "name" => "required | string | max:255",
        ]);

        $image = $request->file('image');

        $new_name = rand() .$request->name. '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        HelperGeneral::createNewImage($new_name);
        $modelImage = new Image();
        $modelImage->name = $request->name;
        $modelImage->file = $request->name."."."webp";
        $modelImage->save();
        return redirect()->route("admin_files")
            ->with('success','Nouvelle image téléchargée.');
    }

    function delete(Request $request)
    {
        if ( $image = $request->get('image') ){
            if(!HelperGeneral::searchImages($image))
                return redirect()->route("admin_files")
                    ->with('error','Le fichier n\'existe pas.');
        } else {
            return redirect()->route("admin_files")
                ->with('error','Mauvais paramètre.');
        }
        $status = HelperGeneral::deleteImage($image);
        if ($status) {
            return redirect()->route("admin_files")
                ->with('message','Image supprimée.');
        } else {
            return redirect()->route("admin_files")
                ->with('error','Erreur lors de la suppression de l\'image.');
        }
    }

}

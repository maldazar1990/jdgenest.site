<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\FileForm;
use App\Http\Forms\TagForm;
use App\Image;
use App\post;
use App\Tags as Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
                $disk = Storage::build([
                    'driver' => 'local',
                    'root' => \public_path(),
                ]);
                $tags["results"] = Image::distinct()
                    ->select("id as id","file as text", "name")
                    ->where("title","LIKE","%".HelperGeneral::clean($request->term)."%")
                    ->orWhere("file","LIKE","%".HelperGeneral::clean($request->term)."%")
                    ->get()->toArray();
                foreach ($tags["results"] as $key => $tag){
                    $imageFile = $tag["text"];
                    if (!Str::contains($imageFile, "images/")) {
                        $imageFile = "images/".$imageFile;
                    } 
                    if (!$disk->exists($imageFile)) {
                        unset($tags["results"][$key]);
                    }
                }
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
        $nameWithoutExtension = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $existImage = Image::where("file","like","%".$nameWithoutExtension."%")->first(); 

        if ($existImage) {
            return redirect()->route("admin_files_create")
                ->with('error','L\'image existe déjà.');
        }

        $new_name = $image->getClientOriginalName();
        $image->move(public_path('images'), $new_name);
        HelperGeneral::createNewImage($new_name);
        $modelImage = new Image();
        $modelImage->name = $request->name;
        $modelImage->file = "images/".$new_name;
        $modelImage->save();
        return redirect()->route("admin_files")
            ->with('message','Nouvelle image téléchargée.');
    }

}

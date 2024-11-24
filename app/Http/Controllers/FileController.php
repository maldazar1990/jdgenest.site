<?php

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGeneral;
use App\Http\Helpers\ImageConverter;
use App\Image;
use App\Jobs\ConvertImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    use TitleIsUnique;
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
    public function create(Request $request) {


        return view("admin.editImage",[
            "title" => "Ajouter une image",
            "model"  => null,
            'route' => route('admin_files_store'),
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

        $name = $request->name;
        if ( Image::where("name",$request->name)->exists() ) {
            $name = Str::slug($request->name."-".time(),"_");
        }

        $new_name = str::slug( $nameWithoutExtension, "_").'.'.$image->getClientOriginalExtension();
        $image->move(\storage_path("images/"), $new_name);



        $imageDb = \App\Image::where("hash",md5_file(\storage_path("images/"). $new_name))->first();
        if ( $imageDb ){
            File::delete(\storage_path("images/"). $new_name);
            return redirect()->route("admin_files_create")
                ->with('error','L\'image existe déjà.');
        }
        File::move(\storage_path("images/"). $new_name, \public_path("images/").$new_name);
        $modelImage = new Image();
        $modelImage->name = $name;
        $modelImage->file = "images/".$new_name;
        $modelImage->hash = md5_file(\public_path("images/").$new_name);
        $modelImage->save();
        dispatch(new ConvertImage($new_name,$imageDb));
        return redirect()->route("admin_files")
            ->with('message','Nouvelle image téléchargée.');
    }

    public function isUnique(Request $request) {

        if($request->ajax()){
            return response()->json($this->isTitleUnique($request,new Image()));
        }
        abort(404);
    }

    public function md5Exist(Request $request) {

        if ($request->ajax()) {

            $model = Image::distinct()
                ->select("id")
                ->where("hash","LIKE","%".HelperGeneral::clean($request->input("hash"))."%")
                ->offset(0)->limit(1)
                ->get()->toArray();

            if(count($model) == 0) {
                return response()->json(["response"=>"true"]);
            } else {
                return response()->json(["response"=>"false"]);
            }

        } else {
            abort(404);
        }
    }

}

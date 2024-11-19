<?php
namespace App\Http\Helpers;

use App\Http\Helpers\Image as HelpersImage;
use App\Infos;
use App\Jobs\ConvertImage;
use App\post;
use App\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class  Image {
    private $image;

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function deleteImage(){

        if ($this->image) {
            $path = "images/";
            $filename = $this->image;
            if (Str::contains($this->image, '.')) {
                $filename = explode(".", $this->image)[0];
            }

            if (self::isImageUsed($this->image) == false and $filename != "default") {
                $arrayFiles = [$path . $this->image,
                    $path . $filename . ".webp",
                    $path . $filename . ".jpg",
                    $path . $filename . ".jpeg",
                    $path . $filename . ".png",
                    $path . $filename . "_medium.webp",
                    $path . $filename . "_small.webp",
                    $path . $filename . "_medium.jpg",
                    $path . $filename . "_small.jpg",
                    $path . $filename . "_medium.jpeg",
                    $path . $filename . "_small.jpeg",
                    $path . $filename . ".avif",
                    $path . $filename . "_medium.avif",
                    $path . $filename . "_small.avif"];

                File::delete($arrayFiles);
                return true;
            }
        }
        return false;
    }

    public static function isImageUsed(string $name){
        $user = Users::where("image","like","%".$name."%")->first();
        $post = post::where("image","like", "%".$name."%")->first();
        $info = Infos::where("image","like", "%".$name."%")->first();
        if ( $user == null and $post == null and $info == null ){
            return false;
        }
        return true;
    }

    public static function getImages():array {
        $images = [];
        
        $exts = ["*.jpeg","*.jpg","*.webp","*.png","*.avif"];
        foreach( $exts as $ext) {
            foreach (glob(\public_path("images/").$ext) as $filename) {
                    if ( Str::contains($filename,["_small","_medium","default"]) )
                        continue;
                    $file = explode("/", $filename);
                    $file = end($file);
                    $index = explode(".",$file)[0];
                    $images[$index] = $file;

            }
        }
        return $images;
    }

    public static function saveNewImage(\Illuminate\Http\Request $request,Model $model):\App\Image|null {

        if ( !$model instanceof Users and !$model instanceof post and !$model instanceof Infos ){
            throw new \Exception("Model not supported");
        }

        if ( !$request->hasFile("image") ){
            return null;
        }


        if ($model->imageClass or $model->image) {

            $imageFile = $model->imageClass??$model->image;

            $img = new HelpersImage($imageFile);
            $img->deleteImage();
        }

        $file = $request->file("image");
        $nameWithoutExtension = Str::slug(explode(".",$file->getClientOriginalName())[0],"_");
        $name = $nameWithoutExtension.".".$file->getClientOriginalExtension();
        $file->move(\storage_path("images/"), $name);

        $imageDb = \App\Image::where("name",'like',"%".$nameWithoutExtension)->orWhere("file",'like',"%".$nameWithoutExtension."%")->orWhere("hash",md5_file(\storage_path("images/"). $name))->first();
        if ( $imageDb ){
            File::delete(\storage_path("images/"). $name);
            $model->image_id = $imageDb->id;
        }else {
            $imageDb = new \App\Image();
            $imageDb->name = $nameWithoutExtension;
            $imageDb->file = "images/".$name;
            File::move(\storage_path("images/"). $name, \public_path("images/").$name);
            $imageDb->hash = md5_file(\public_path("images/").$name);
            $imageDb->save();
            dispatch(new ConvertImage($name,$model));
            $model->image_id = $imageDb->id;
        }
        return $imageDb;
    }

}
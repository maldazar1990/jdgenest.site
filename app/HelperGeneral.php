<?php

namespace App;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HelperGeneral
{
    static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    public static function resizeImage($new_width, $new_height, $image, $width, $height)
    {
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        return $new_image;
    }

    public static function resizeImagesForThumb( $width, $height, $img, $newfile, $quality = 90, $format = "webp" ) {
        $function = "imagewebp";
        if ($format == "avif") {
            $function = "imagewebp";
        }
        call_user_func($function,self::resizeImage($width/2,$height/2,$img,$width,$height), $newfile . "_medium.".$format,$quality-10);
        call_user_func($function,self::resizeImage($width/3,$height/3,$img,$width,$height), $newfile . "_small.".$format,$quality-20);
    }

    public static function urlValide($url){
        $headers = @get_headers($url);
        if(strpos($headers[0],'200')===false)return false;
        return true;
    }

    public static function createNewImage($image)
    {
        $path = "images/";
        $quality = 80;

        if(file_exists(public_path("images/").$image)) {
            $filename = explode(".", $image)[0];
            $imageWithPath = $path . $image;
            $format = exif_imagetype($imageWithPath);
            $data = getimagesize($imageWithPath);
            $width = $data[0];
            $height = $data[1];
            if ( $format == IMAGETYPE_JPEG or $format == IMAGETYPE_JPEG2000 ) {

                $img = imagecreatefromjpeg( $path . $image);
                imagewebp($img, $path.$filename.".webp");

                self::resizeImagesForThumb($width, $height, $img, $path . $filename, $quality);
            }

            if ( $format == IMAGETYPE_PNG ) {
                $img = imagecreatefrompng( $path . $image);
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                imagewebp($img, $path.$filename.".webp");
                imagejpeg( $img,$path . $filename.".jpeg");
                self::resizeImagesForThumb($width, $height, $img, $path . $filename, $quality);
            }

            if ( $format == IMAGETYPE_WEBP ) {


                $img = imagecreatefromwebp($path.$image);
                imagejpeg( $img,$path . $filename.".jpeg");
                self::resizeImagesForThumb($width, $height, $img, $path . $filename, $quality);
            }

            if (function_exists('imageavif')) {
                imageavif($img, $path . $filename . ".avif",$quality);
                self::resizeImagesForThumb($width, $height, $img, $path . $filename, $quality, "avif");
            }

        }

    }

    public static function searchImages($name)
    {
        $images = [];
        $path = "images/";
        $files = File::files(\public_path().$path);
        foreach ($files as $file) {
            if (Str::contains($file, self::clean($name))) {
                $images[] = $file;
            }
        }
        return count($images)>0?$images:false;

    }

    public static function deleteImage($image){


        $path = "images/";
        $filename = $image;
        if (Str::contains($image, '.')) {
            $filename = explode(".",$image)[0];
        }

        if( self::isImageUsed($image) == false and $filename != "default") {
            $arrayFiles= [$path . $image,
                $path . $filename . ".webp",
                $path . $filename . ".jpg",
                $path . $filename . ".jpeg",
                $path . $filename . ".png",
                $path . $filename . "_medium.webp",
                $path . $filename . "_small.webp",
                $path . $filename . ".avif",
                $path . $filename . "_medium.avif",
                $path . $filename . "_small.avif"];

            File::delete($arrayFiles);
            return true;
        }
        return false;
    }

    public static function isImageUsed($name){
        $user = Users::where("image",$name)->first();
        $post = post::where("image",$name)->first();
        $info = Infos::where("image",$name)->first();
        if ( $user == null and $post == null and $info == null ){
            return false;
        }
        return true;
    }

    public static function getImages() {
        $images = [];
        $path = "/images/";
        $exts = ["*.jpeg","*.jpg","*.webp"];
        foreach( $exts as $ext) {
            foreach (glob(\public_path("images/").$path.$ext) as $filename) {
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

    static function wordToMinute($text){
        return round(str_word_count($text)/200);
    }
}

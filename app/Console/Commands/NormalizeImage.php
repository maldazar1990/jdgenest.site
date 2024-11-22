<?php

namespace App\Console\Commands;

use App\Http\Helpers\ImageConverter;
use App\Image;
use App\Infos;
use App\post;
use App\Users;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NormalizeImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:normalize-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(Image::all() as $imageRecord) {
            $image = $imageRecord->file;
            Log::info($image);


            $path = public_path("images/");

            if (!str_contains($image, "images/")) {
                $imageWithPath = $path . $image;
                $image = "images/" . $image;
            } else {
                $imageWithPath = public_path() . "/" . $image;
            }

            $filename = explode('.', $image);

            $extension = "";
            if (!isset($filename[1])) {

                $format = mime_content_type($imageWithPath);
                switch ($format) {
                    case "image/jpeg":
                        $imageRecord->file = $filename[0] . ".jpg";

                        $imageRecord->save();
                        $extension = ".jpg";
                        break;
                    case "image/png":
                        $imageRecord->file = $filename[0] . ".png";
                        $imageRecord->save();
                        $extension = ".png";
                        break;
                    case "image/gif":
                        $imageRecord->file = $filename[0] . ".gif";
                        $imageRecord->save();
                        $extension = ".gif";
                        break;
                    case "image/webp":
                        $imageRecord->file = $filename[0] . ".webp";
                        $imageRecord->save();
                        $extension = ".webp";
                        break;
                    case "image/avif":
                        $imageRecord->file = $filename[0] . ".avif";
                        $imageRecord->save();
                        $extension = ".avif";
                        break;
                    case "image/svg+xml":
                        $imageRecord->file = $filename[0] . ".svg";
                        $imageRecord->save();
                        $extension = ".svg";
                        break;

                    default:
                        Log::info("image format not supported");
                        break;
                }

                if ($extension) {
                    File::move($imageWithPath, $imageWithPath . $extension);
                    $imageWithPath = $imageWithPath . $extension;
                }


            } else {
                $extension = "." . $filename[1];
            }

            if ($extension == "") {
                Log::info("image format not supported");
                continue;
            }

            $fileExist = true;

            if (File::exists($imageWithPath) == false) {
                $files = File::glob($filename[0] . ".*");
                if ( $files ) {
                    $file = $files[0];
                    $filename = explode("/", $file);
                    $filename = end($filename);
                    $imageWithPath = $path . $filename;
                    $imageRecord->file = "images/".$filename;

                } else {
                    $fileExist = false;
                }
            }

            if ($fileExist) {
                $md5 = md5_file($imageWithPath);
                $imageRecord->hash = $md5;
                $imageRecord->save();
                Log::info("Image " . $image . " normalized");
            } else {
                Log::info("Image " . $image . " not found");
                post::where("image_id", $imageRecord->id)->update(["image_id" => null]);
                Infos::where("image_id", $imageRecord->id)->update(["image_id" => null]);
                Users::where("image_id", $imageRecord->id)->update(["image_id" => null]);
                $imageRecord->delete();
                Log::info("Image " . $image . " deleted");
            }
        }
        Log::info("Normalization of images completed");

        Log::info("normalization image post begin");
        foreach(post::all() as $post) {
            if ( !$post->image_id and $post->image ) {
                $image = Image::where("file","like","%".$post->image."%")->orWhere("name","like","%".$post->image."%")->first();
                if ( $image ) {
                    $post->image_id = $image->id;
                    $post->save();
                    Log::info("Post ".$post->title." image normalized");
                } else {

                    if ( $post->image ) {

                        $imageWithPath = $post->image;

                        if( Str::contains($imageWithPath,"images/") == false ){
                            $imageWithPath = public_path()."/".$imageWithPath;
                        }

                        if( File::exists(public_path().$imageWithPath) ) {
                            $md5 = md5_file(public_path().$imageWithPath);
                            $image = Image::where("hash",$md5)->first();
                            if ( $image ) {
                                $post->image_id = $image->id;
                                $post->save();
                                Log::info("Post ".$post->title." image normalized");
                            } else {
                                $newImage = new Image();
                                $newImage->file = $imageWithPath;
                                $newImage->hash = $md5;
                                $newImage->name = $post->image;
                                $newImage->save();
                                dispatch(new ImageConverter($newImage->name,$newImage));
                                $post->image_id = $newImage->id;
                                $post->save();
                                Log::info("Post ".$post->title." image normalized");
                            }
                        } else {
                            $post->image = null;
                            $post->save();
                            Log::info("Post ".$post->title." image deleted");
                        }

                    }
                }
            }
        }
        Log::info("normalization image post completed");
        Log::info("normalization image infos begin");
        foreach(Infos::all() as $info) {
            if ( !$info->image_id and $info->image ) {

                if ( Str::isUrl($this->image) ) {
                    Log::info("info ".$info->title." image is url");
                    continue;
                }

                $image = Image::where("file","like","%".$info->image."%")->orWhere("name","like","%".$info->image."%")->first();
                if ( $image ) {
                    $info->image_id = $image->id;
                    $info->save();
                    Log::info("info ".$info->title." image normalized");
                } else {

                    if ( $info->image ) {

                        $imageWithPath = $info->image;
                        if( Str::contains($imageWithPath,"images/") == false ){
                            $imageWithPath = public_path()."/".$imageWithPath;
                        }

                        if( File::exists(public_path().$imageWithPath) ) {
                            $md5 = md5_file(public_path().$imageWithPath);
                            $image = Image::where("hash",$md5)->first();
                            if ( $image ) {
                                $info->image_id = $image->id;
                                $info->save();
                                Log::info("info ".$info->title." image normalized");
                            } else {
                                $newImage = new Image();
                                $newImage->file = $imageWithPath;
                                $newImage->hash = $md5;
                                $newImage->name = $info->image;
                                $newImage->save();
                                dispatch(new ImageConverter($newImage->name,$newImage));
                                $info->image_id = $newImage->id;
                                $info->save();
                                Log::info("info ".$info->title." image normalized");
                            }
                        } else {
                            $info->image = null;
                            $info->save();
                            Log::info("info ".$info->title." image deleted");
                        }

                    }
                }
            }
        }
        Log::info("normalization image infos completed");
    }


}

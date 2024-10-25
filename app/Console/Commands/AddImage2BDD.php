<?php

namespace App\Console\Commands;

use App\HelperGeneral;
use App\Image as Image;
use App\post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddImage2BDD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:image2bdd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ajoute les images dans la bdd';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
  
        /*$images = HelperGeneral::getImages();
        foreach($images as $name => $image){
            $name = \str_replace("_small","",$name);
            $name = \str_replace("_medium","",$name);
            $name = \str_replace("jpg","",$name);
            $images = Image::where("name",'like',"%".$name."%")->get();
            if ($images->count() == 0) {
                $newImage = new Image();
                $newImage->name = $name;
                $newImage->file = "images/".$name;
                $newImage->save();
            }
        }*/
        post::where("image","")->update(["image"=>"default"]);
        foreach(Image::all() as $img){
            $filename = $img->name;
            $path = \public_path("images/");
            if (\str_contains($img->file, ".") == false) {
                $files = File::glob($path."*".$img->file.".*");
                $ext = File::extension($files[0]);
                dump($files);
            
            }
            /*if (\str_contains($img->file, "images/") == false) {
                
                $img->file = "images/".$img->file;
                $img->save();
            }*/
        }

        return Command::SUCCESS;
    }
}

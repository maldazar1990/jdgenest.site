<?php

namespace App\Http\Livewire;

use App\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use LaravelViews\Views\GridView;
use Illuminate\Support\Str;

class ImageGridView extends GridView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Image::class;
    public $maxCols = 3;
    protected $paginate = 10;
    private $disk;

    public function __construct()
    {
        $this->disk = Storage::build([
            'driver' => 'local',
            'root' => \public_path(),
        ]);
    }

    public function sortableBy()
    {
        return [
            'Name' => 'name',
        ];
    }

    /**
     * Sets the data to every card on the view
     *
     * @param $model Current model for each card
     */
    public function card($model)
    {
        $imageFile = $model->file;
        

        if (Str::contains($imageFile, 'http')) {
            return [
                "image" => $imageFile,
                "title"=>$model->name,
            ];
        }
        
        if (!Str::contains($imageFile, "images/")) {
            $imageFile = "images/".$imageFile;
        } 
        if (!$this->disk->exists($imageFile)) {
           
            $dir = public_path('images/');
            $files =  scandir ($dir);
            $match = $model->name;
            $found = false;
            foreach ($files as $file) {
                if(stripos($file, $match) != false){
                    $imageFile="images/".$file;
                    $found = true;
                    break;
                }
                    
            }

            if (!$found) {
                $imageFile = "images/default.jpg";
            }
        }

        return [
            "image" => config("app.url")."/".$imageFile,
            "title"=>$model->name,
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteImagesAction,
        ];
    }
}

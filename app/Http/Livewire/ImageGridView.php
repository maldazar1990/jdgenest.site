<?php

namespace App\Http\Livewire;

use App\Image;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Views\GridView;

class ImageGridView extends GridView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Image::class;
    public $maxCols = 3;
    protected $paginate = 10;

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
        if ( !\str_contains($imageFile,".webp") and !\str_contains($imageFile,".avif") and !\str_contains($imageFile,".jpeg") and !\str_contains($imageFile,".jpg") ) {
            $imageFile = $imageFile.".webp";
        }

        if ( !\str_contains($imageFile,'images/') )
            $imageFile = "images/".$imageFile;

        return [
            "image" => "/images/".$imageFile,
            "title"=>$model->name,
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteImagesAction,
        ];
    }
}

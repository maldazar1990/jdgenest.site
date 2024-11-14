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
    public $sortOrder = 'desc';
    public $sortBy = 'created_at';
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
        $title = substr($model->name,0,"15")."-".$model->created_at;
        $selected = true;
        if (isset($model->post->id)) {
            $title = "<b style='color:red;'>".$title."</b>";
            $selected = false;
        }

        return [
            "image" => asset($model->file),
            "title"=>$title,
            "selected" => $selected,
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteImagesAction,
        ];
    }
}

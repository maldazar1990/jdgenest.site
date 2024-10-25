<?php

namespace App\Actions;

use App\HelperGeneral;
use App\Image;
use App\post;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteImagesAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Supprimer des images";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash";

    public function getConfirmationMessage($model)
    {
        return "Voulez vous vraiment supprimer ces images ?";
    }
    /**
     * Execute the action when the user clicked on the button
     *
     * @param Array $selectedModels Array with all the id of the selected models
     * @param $view Current view where the action was executed from
     */
    public function handle($selectedModels, View $view)
    {
        try {
            foreach ($selectedModels as $idModel) {
                $model = Image::where('id',$idModel);
                $post = post::where("image_od",$idModel)->first();
                if (HelperGeneral::isImageUsed($model->name) or $post) {
                    HelperGeneral::deleteImage($model->file);
                    $model->delete();
                } else {
                    $this->error("L'image " . $model->name . " est utilisée dans une page, elle ne peut pas être supprimée");
                    return true;
                }
            }
            $this->success("Supprimé avec succès");
            return true;
        } catch (\Exception $e) {
            $this->error("Erreur lors de la suppression \n" . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n");
            return true;
        }
    }
}

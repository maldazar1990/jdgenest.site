<?php

namespace App\Actions;

use App\HelperGeneral;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteInfoAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "supprimer";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash";

    public function getConfirmationMessage($model)
    {
        return "Voulez vous vraiment supprimer l'information ".$model->title." ?";
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        HelperGeneral::deleteImage($model->image);
        $model->tags()->detach();
        $model->delete();

        $this->success("Supprimé avec succès");
        return true;
    }
}

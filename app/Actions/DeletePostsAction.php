<?php

namespace App\Actions;

use App\post;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeletePostsAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Supprimez des postes";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash-2";
    public function getConfirmationMessage($model)
    {
        return "Voulez vous vraiment supprimer ces articles ?";
    }
    /**
     * Execute the action when the user clicked on the button
     *
     * @param Array $selectedModels Array with all the id of the selected models
     * @param $view Current view where the action was executed from
     */
    public function handle($selectedModels, View $view)
    {
        post::whereKey($selectedModels)->update([
            'status' => '2'
        ]);

        $this->success("Supprimés avec succès");
    }
}

<?php

namespace App\Actions;

use App\options_table;
use Illuminate\Support\Facades\Cache;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteConfigAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "supprimer";

    public function getConfirmationMessage($model)
    {
        return "Voulez vous vraiment supprimer cette option ?";
    }

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param Array $selectedModels Array with all the id of the selected models
     * @param $view Current view where the action was executed from
     */
    public function handle($selectedModels, View $view)
    {
        options_table::whereKey($selectedModels)->delete();
        Cache::forget('optionsArray');
        $this->success('Option supprimé avec succès');
        return true;
    }
}

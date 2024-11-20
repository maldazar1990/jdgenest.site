<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class BanCommentAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "Ban troll";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "cancel";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {


        if(!empty(trim($model->ip))) {
            FireWallRepository::createReport($model->ip, 2, "Bannie par l'administrateur");
        }

        $model->delete();
        $this->success('Message banni avec succès');
    }
}

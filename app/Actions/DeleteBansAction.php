<?php

namespace App\Actions;

use App\Current;
use App\FirewallIp;
use App\Model;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteBansAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "supprimer";
    public function getConfirmationMessage($model)
    {
        return "Voulez vous vraiment supprimer?";
    }

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash";


    /**
     * Execute the action when the user clicked on the button
     *
     * @param $view Current view where the action was executed from
     */
    public function handle($selectedModels, View $view)
    {
        FirewallIp::whereKey($selectedModels)->delete();
        $this->success('IPS supprimés avec succès');
        return true;
    }
}

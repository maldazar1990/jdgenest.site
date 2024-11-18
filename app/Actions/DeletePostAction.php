<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeletePostAction extends Action
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
        return "Voulez vous vraiment supprimer l'article ".$model->title." ?";
    }
    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        $model->status = 2;
        if ( Cache::has('post_id_'.$model->id) )
            Cache::forget('post_id_'.$model->id);
        if ( Cache::has('post_slug_'.$model->slug) )
            Cache::forget('post_slug_'.$model->slug);

        Cache::forget('allPosts');
        $model->save();
        $this->success("Supprimé avec succès");
    }
}

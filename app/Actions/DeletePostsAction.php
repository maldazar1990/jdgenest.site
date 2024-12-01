<?php

namespace App\Actions;

use App\post;
use Illuminate\Support\Facades\Cache;
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

        foreach ($selectedModels as $id) {
            if ( Cache::has('post_id_'.$id) )
                Cache::forget('post_id_'.$id);
            if ( Cache::has('post_slug_'.$id) )
                Cache::forget('post_slug_'.$id);
        }

        $page = post::where('status', 0)->count() / config('app.maxblog');
        for ($i = 0; $i <= $page; $i++) {
            if ( Cache::has('post_page_'.$i) )
                Cache::forget('post_page_'.$i);
        }
        $this->success("Supprimés avec succès");
    }
}

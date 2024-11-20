<?php

namespace App\Actions;

use App\Contact;
use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;

class DeleteMessageAction extends Action
{
    use Confirmable;

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

    public function getConfirmationMessage($item = null)
    {
        return 'Êtes-vous sûr de vouloir supprimer ce message?';	
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param Array $selectedModels Array with all the id of the selected models
     * @param $view Current view where the action was executed from
     */
    public function handle($selectedModels, View $view)
    {
        // Your code here
        Contact::whereKey($selectedModels)->delete();
        $this->success('Message supprimé avec succès');
        return Redirect()->route('admin_msg');
        
    }
}

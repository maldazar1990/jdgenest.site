<?php

namespace App\Http\Livewire;

use App\Actions\DeleteMessageAction;
use App\Contact;
use Illuminate\Support\Facades\Crypt;
use LaravelViews\Views\DetailView;

class MessageDetailView extends DetailView
{
    public $title = "Détail du message";
    protected $modelClass = Contact::class;
    /**
     * @param $model Model instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model)
    {
        return [
            'Nom' =>Crypt::decryptString($model->name),
            'Email' => Crypt::decryptString($model->email),
            'Message' => $model->text,
            'Date' => $model->created_at->format("d/m/Y"),
        ];
    }

    public function actions() {
        return [
            new DeleteMessageAction(),
        ];
    }
}

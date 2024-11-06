<?php

namespace App\Http\Livewire;
use LaravelViews\Facades\Header;
use App\Contact;
use Illuminate\Support\Facades\Crypt;
use LaravelViews\Views\TableView;

class MessageTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Contact::class;
    public $searchBy = ['name', 'email', 'message'];
    protected $paginate = 10;
    public $sortOrder = 'desc';
    public $sortBy = 'id';
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title('Nom')->sortBy('name'),
            Header::title('Email')->sortBy('email'),
            Header::title('Message')->sortBy('text'),
            Header::title('Date')->sortBy('created_at'),
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        $name = substr(Crypt::decryptString($model->name),0,20);
        return [
            "<a href='".route("admin_msg_show",$model)."'>" . $name . "</a>",
            substr(Crypt::decryptString($model->email),0,50),
            substr($model->text,0,20),
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteMessageAction(),
        ];
    }
}

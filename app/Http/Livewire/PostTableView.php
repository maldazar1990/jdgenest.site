<?php

namespace App\Http\Livewire;

use App\post;
use LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
use Illuminate\Support\Facades\Request as  Request;
class PostTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $paginate = 10;

    public $searchBy = ['title', 'post'];
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */

    public function repository(){
        return Post::query();

    }

    public function headers(): array
    {
        return [
            Header::title("Titre")->sortBy("title"),
            Header::title("Date de création")->sortBy("created_at"),
            "Status",
        ];
    }

    public function actionsByRow(){
        return [
            new \App\Actions\EditPostAction,
            new \App\Actions\DeletePostAction,
        ];
    }

    public function bulkActions(){
        return [
            new \App\Actions\DeletePostsAction,
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        return [
            $model->title,
            $model->created_at->format("d/m/Y"),
            config("app.status")[$model->status],
        ];
    }
}

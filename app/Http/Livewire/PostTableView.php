<?php

namespace App\Http\Livewire;

use App\post;
use LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
class PostTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $paginate = 10;
    public $sortOrder = 'desc';
    protected $model = post::class;
    public $sortBy = 'created_at';
    public $searchBy = ['title', 'post'];
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */

    public function headers(): array
    {
        return [
            Header::title("Titre")->sortBy("title"),
            Header::title("Date de création")->sortBy("created_at"),
            "Article",
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
            "<a href='".route('admin_posts_edit', $model->id)."'>".$model->title."</a>",
            $model->created_at->format("d/m/Y"),
            "<a href='".route('post', $model->slug)."' target='_blank' rel='noopener noreferrer'>".$model->title."</a>",
            config("app.status")[$model->status],
        ];
    }
}

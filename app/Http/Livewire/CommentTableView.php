<?php

namespace App\Http\Livewire;
use LaravelViews\Facades\Header;
use App\Comment;
use App\post;
use LaravelViews\Views\TableView;

class CommentTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Comment::class;
    protected $paginate = 10;
    public $searchBy = ["post"];

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            "poste",
            "article",
            Header::title("date")->sortBy("created_at"),
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        $post = post::find($model->post_id);
        return [
            substr($model->post,0,20)."...",
            $post->title,
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteCommentsAction(),
        ];
    }
}

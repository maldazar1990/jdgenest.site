<?php

namespace App\Http\Livewire;
use App\Actions\BanContactAction;
use LaravelViews\Facades\Header;
use App\Comment;
use App\post;
use LaravelViews\Data\QueryStringData;
use LaravelViews\Views\TableView;

class CommentTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Comment::class;
    protected $paginate = 10;
    public $sortOrder = 'desc';
    public $sortBy = 'created_at';
    public $searchBy = ["post"];
    public $idPost = null;

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */

    public function repository()
    {
        $query = Comment::query();
        if($this->idPost){
            $query->where("post_id",$this->idPost);
        }
        return $query;
    }
    
    public function headers(): array
    {
        return [
            "poste",
            "article",
            Header::title("date")->sortBy("created_at"),
        ];
    }

    public function mount($idPost = null)
    {   
        if($idPost){
            $this->idPost = $idPost;
        }
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
            "<a href='".route("admin_posts_edit",$post)."'>".$post->title."</a>",
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function bulkActions() {
        return [
            new \App\Actions\DeleteCommentsAction(),
            new BanContactAction(),
        ];
    }
}

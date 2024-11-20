<?php

namespace App\Http\Livewire;

use App\Actions\EditTagAction;
use App\Infos;
use App\Tags;
use Illuminate\Support\Facades\Validator;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Views\TableView;
use LaravelViews\Views\Traits\WithAlerts;

class TagTableView extends TableView
{
    use WithAlerts;
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Tags::class;
    protected $paginate = 10;
    public $searchBy = ['title'];
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title("Titre")->sortBy('title'),
            Header::title("Date de création")->sortBy('created_at'),
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
            UI::editable($model, "title"),
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function actionsByRow(){
        return [
            new EditTagAction(),
            new \App\Actions\DeleteTagAction,
        ];
    }

    public function update(Tags $model, $data){

        $validator = Validator::make($data, [
            'term' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            $this->error("Erreur de validation");
        } else {

            $model->update($data);
            $this->success("Mise à jour avec succès");
        }
    }
}

<?php

namespace App\Http\Livewire;

use App\Infos;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Views\TableView;
use LaravelViews\Views\Traits\WithAlerts;

class InfoTableView extends TableView
{
    use WithAlerts;
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Infos::class;
    public $searchBy = ['title', 'description'];
    protected $paginate = 10;
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title("titre")->sortBy("title"),
            Header::title("Date de création")->sortBy("created_at"),
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

        ];
    }


    public function actionsByRow(){
        return [
            new \App\Actions\EditInfoAction,
            new \App\Actions\DeleteInfoAction,
        ];
    }
}

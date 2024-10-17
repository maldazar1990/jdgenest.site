<?php

namespace App\Http\Livewire;

use App\Role;
use App\Tags;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Views\TableView;
use LaravelViews\Views\Traits\WithAlerts;

class RoleTableView extends TableView
{
    use WithAlerts;
    /**
     * Sets a model class to get the initial data
     */
    protected $model = Role::class;
    protected $paginate = 10;
    public $searchBy = ['name'];

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title("Titre")->sortBy('name'),
            "Description",
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
            UI::editable($model,"name"),
            UI::editable($model,"description"),
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function ActionsByRow(){
        return [
            new \App\Actions\EditRoleAction,
            new \App\Actions\DeleteRoleAction,
        ];
    }
    public function update(Role $model, $data){
        $model->update($data);
        $this->success("Mise à jour avec succès");
    }

}

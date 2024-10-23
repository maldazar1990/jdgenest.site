<?php

namespace App\Http\Livewire;

use App\options_table;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Views\TableView;
use LaravelViews\Views\Traits\WithAlerts;
class ConfigView extends TableView
{
    use WithAlerts;
    /**
     * Sets a model class to get the initial data
     */
    protected $model = options_table::class;
    protected $paginate = 10;
    public $searchBy = ["option_name"];

        /**
         * Sets the headers of the table as you want to be displayed
         *
         * @return array<string> Array of headers
         */
        public function headers(): array
        {
            return [
                "Nom",
                "Valeur",
                Header::title("Date de création")->sortBy("created_at"),
            ];
        }


        public function row($model): array
        {
            return [
                UI::editable($model,"option_name"),
                UI::editable($model,"option_value"),
                $model->created_at->format("d/m/Y"),
            ];
        }
    
        public function ActionsByRow(){
            return [
                new \App\Actions\UpdateConfigAction,
                new \App\Actions\DeleteConfigAction,
            ];
        }
        public function update(options_table $model, $data){
            $model->update($data);
            $this->success("Mise à jour avec succès");
        }
}
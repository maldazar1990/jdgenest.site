<?php

namespace App\Http\Livewire;
use LaravelViews\Facades\Header;
use App\FirewallIp;
use LaravelViews\Views\TableView;

class BanTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected $model = FirewallIp::class;
    protected $paginate = 10;
    public $sortOrder = 'desc';
    public $sortBy = 'created_at';
    public $searchBy = ["ip"];
    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            Header::title("IP")->sortBy("ip"),
            "Raison",
            Header::title("Date")->sortBy("created_at"),

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
            $model->ip,
            isset($model->log->middleware)?$model->log->middleware:"aucune",
            $model->created_at->format("d/m/Y"),
        ];
    }

    public function actionsByRow(){
        return [
            new \App\Actions\DeleteBanAction,
        ];
    }

    public function bulkActions(){
        return [
            new \App\Actions\DeleteBansAction,
        ];
    }
}

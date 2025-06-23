<?php

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGeneral;
use Illuminate\Http\Request;

trait TitleIsUnique
{

    public function isTitleUnique(Request $request,$model):array
    {

        $objs = $model::distinct()
            ->select("id as id")
            ->where("title", "LIKE", "%" . HelperGeneral::sanitize($request->get("title")) . "%")
            ->offset(0)->limit(1)
            ->get()->toArray();

        if (count($objs) == 0) {
            return ["response" => "true"];
        } else {
            return ["response" => "false"];
        }


    }

}
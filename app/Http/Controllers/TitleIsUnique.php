<?php

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGeneral;
use Illuminate\Http\Request;

trait TitleIsUnique
{

    public function isUnique(Request $request,Model $model) {

        if ($request->ajax()) {
            $objs = $model::distinct()
                ->select("post.id as id")
                ->where("title","LIKE","%".HelperGeneral::clean($request->get("title"))."%")
                ->offset(0)->limit(1)
                ->get()->toArray();

            if(count($objs) == 0) {
                return response()->json(["response"=>"true"]);
            } else {
                return response()->json(["response"=>"false"]);
            }

        } else {
            abort(404);
            return null;
        }
    }

}
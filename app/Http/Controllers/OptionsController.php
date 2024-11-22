<?php

namespace App\Http\Controllers;

use App\Http\Forms\OptionForm;
use App\options_table;
use Crivion\Options\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [

            "title" => "Options",
            "liveWireTable" => "config-view",
        ]);
    }

    public function rules (  ) {
        return [

            'option_name' => "required|max:255 ",

        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        return view('admin.editOption', [
            'title' => 'Ajouter une option',
            "route"=>route('admin_options_insert'),
            "model"  => null,
        ]);

    }

    public function generalOptions(Request $request){
        $options = Options::getOptions();
        return view('admin.generalOptions', [
            'title' => 'Options générales',
            'options' => $options,
        ]);
    }

    public function saveGeneralOptions(Request $request){
        $options = Options::getOptions();
        foreach($options as $option){
            $option->option_value = $request->input($option->option_name);
            $option->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = $this->rules();
        $rules['option_name'] .= "|unique:options_table,option_name";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $option = new options_table();
        $option->option_name = $request->option_name;
        $option->option_value = $request->option_value;
        $option->save();
        Cache::forget('optionsArray');
        return redirect()->route('admin_options')->with('message', 'Option ajoutée avec succès');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\options_table  $options_table
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$formBuilder, $id)
    {
        $options = options_table::find($id);

        if (!$options) {
            return redirect()->route('admin_options');
        }

        return view('admin.edit', [
            'title' => 'Modifier une option',
            'model' => $options,
            'route' => route('admin_options_update', $id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\options_table  $options_table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $options = options_table::find($id);

        if (!$options) {
            return redirect()->route('admin_options');
        }

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $options->option_name = $request->option_name;
        $options->option_value = $request->option_value;
        $options->save();

        return redirect()->route('admin_options')->with('message', 'Option modifiée avec succès');
    }

}

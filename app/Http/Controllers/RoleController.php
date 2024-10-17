<?php

namespace App\Http\Controllers;

use App\Http\Forms\RoleForm;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Kris\LaravelFormBuilder\FormBuilder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProvider = new EloquentDataProvider(Role::query());
        return view('admin.index', [

            "title" => "Rôles",
            "liveWireTable" => "role-table-view",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\Kris\LaravelFormBuilder\FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RoleForm::class, [
            'method' => 'POST',
            'url' => route("admin_role_insert"),
        ]);

        return view("admin.edit",[
            "title" => "Créer un role",
            "form"  => $form,
        ]);
    }

    public function rules (  ) {
        return [

            'name' => "required | unique:roles,name | max:255",
            "description" => "max:255",

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('admin_role_create')
                ->withErrors($validator)
                ->withInput();
        }

        $role = new Role();
        $role->name = $request->input("name");
        $role->description = $request->input("description");
        $role->save();
        $request->session()->flash('success', 'Enregistrer avec succès');
        return redirect()->route('admin_role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, FormBuilder $formBuilder,$id)
    {
        $role = Role::find($id);
        $form = $formBuilder->create(RoleForm::class, [
            'method' => 'POST',
            'url' => route("admin_role_update",[$role]),
            'model' => $role,
        ]);

        return view("admin.edit",[
            "title" => "Créer un role",
            "form"  => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role,$id)
    {
        $validator = Validator::make($request->all(), $this->rules());
        $role = Role::find($id);

        if ($validator->fails()) {
            return redirect()->route('admin_role_create')
                ->withErrors($validator)
                ->withInput();
        }

        $role->name = $request->input("name");
        $role->description = $request->input("description");
        $role->save();
        $request->session()->flash('success', 'Enregistrer avec succès');
        return redirect()->route('admin_role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $role = Role::where( 'id', $id )->first();
        if ($role->users()->count() > 0 or $role->name == "admin") {
            $request->session()->flash('error', 'Impossible de supprimer ce role, il est utilisé');
            return redirect()->route('admin_role');
        }
        $role->delete();

        $request->session()->flash('message', "Enregistrer avec succès");
        return redirect()->route('admin_role');
    }
}

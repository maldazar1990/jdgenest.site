<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\NewUserForm;
use App\Http\Forms\UserForm;
use App\Role;
use App\Tags as Tags;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Kris\LaravelFormBuilder\FormBuilder;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function current( Request $request, FormBuilder $formBuilder )
    {
        $user =  auth()->user();

        $form = $formBuilder->create(($user->roles()->where("name","admin")->count() > 0)?UserForm::class:NewUserForm::class, [
            'method' => 'POST',
            'url' => route('admin_user_update', $user->id),
            'model' => $user,
        ]);



        return view( "admin.edit", [
            "title"=>"Gestion du profil",
            "form" => $form,
        ] );
    }



    public function rules ($id=false) {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email:strict,dns',
                'max:255',
                Rule::unique('users')->ignore($id),

            ],
            'jobTitle' => "max:255",
            "image" => config("app.rule_image"),

        ];
    }

    public function create (Request $request, FormBuilder $formBuilder) {
        $form = $formBuilder->create(NewUserForm::class, [
            'method' => 'POST',
            'url' => route("admin_user_store"),
        ]);

        return view("admin.edit",[
            "title" => "Créer un utilisateur",
            "form"  => $form,
        ]);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('admin_user_create')
                ->withErrors($validator)
                ->withInput();
        }
        $role = Role::findFromName("guest");
        if (!$role) {
            $role = new Role();
            $role->name = "guest";
            $role->save();
        }

        $user = new Users();
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->password);
        $user->save($role);
        $user->roles()->attach(Role::findFromName("guest"));
        $request->session()->flash('success', 'Enregistrer avec succès');
        return redirect()->route('admin_user_list');
    }

    public function edit (Request $request, FormBuilder $formBuilder,$id) {
        $user = Users::where( 'id', $id )->first();
        $form = $formBuilder->create(($user->roles()->where("name","admin")->count() > 0)?UserForm::class:NewUserForm::class, [
            'method' => 'POST',
            'url' => route("admin_user_update", $id),
            'model' => $user,
        ]);

        return view("admin.edit",[
            "title" => "Modifier un utilisateur",
            "form"  => $form,
        ]);
    }

    public function delete (Request $request,$id) {
        $user = Users::where( 'id', $id )->first();

        if ( $user->id == auth()->user()->id ) {
            $request->session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte');
            return redirect()->route('admin_user_list');
        }

        if ( $user->roles()->where("name","admin")->count() > 0 ) {
            $request->session()->flash('error', 'Vous ne pouvez pas supprimer un compte administrateur');
            return redirect()->route('admin_user_list');
        }

        $user->delete();

        $request->session()->flash('message', "Enregistrer avec succès");
        return redirect()->route('admin_user_list');

    }

    public function index (Request $request) {
        $dataProvider = new EloquentDataProvider(Users::query()->where('id','!=',auth()->user()->id));
        return view('admin.index', [

            "title" => "Utilisateur",
            "gridviews" => [
                "dataProvider" => $dataProvider,
                'rowsFormAction' => route('admin_user_create'),
                'title' => "liste des utilisateurs",
                "infos" => "Les utilisateurs peuvent modifié et corrigé les informations du site",
                'useFilters' => true,
                'columnFields' => [
                    [
                        "label" => "Nom",
                        "value" => function ( $model ) {
                            return $model->name;
                        },
                    ],
                    [
                        "label"=>"Role",
                        "value" => function ( $model ) {
                            return $model->roles()->first()->name;
                        },
                    ],
                    [
                        "label" => "Actions",
                        'class' => \Itstructure\GridView\Columns\ActionColumn::class,
                        "htmlAttributes" => [
                            "width" => "25%",
                        ],
                        'actionTypes' => [

                            'edit' => function ( $data) {
                                return route('admin_user_edit', [$data]);
                            },
                            'delete' => function ($data) {
                                return route('admin_user_delete', [$data]);
                            },
                        ]
                    ]

                ],
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = Users::where( 'id', $id )->first();
        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
            return redirect()->route('admin_user')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ( $request->image and $user->roles()->where("name","admin")->count() > 0 ) {
            HelperGeneral::deleteImage($user->image);
            $file = $request->file("image");
            $name = Str::slug(time() . $file->getClientOriginalName()).$file->getClientOriginalExtension();
            $file->move(public_path("images"), $name);
            HelperGeneral::createNewImage($name);
            $user->image = $name;
        }
        $user->email = $request->input("email");

        if ( $request->password ) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->input("name");

        if ( $user->roles()->where("name","admin")->count() > 0 ) {
            $user->adress = $request->input("adress");
            $user->presentation = $request->input("presentation");
            $user->jobTitle = $request->input("jobTitle");
        }


        $user->save();
        $request->session()->flash('message', 'Task was successful!');
        if ( $user->id == auth()->user()->id ) {
            return redirect()->route('admin_user');
        }
        return redirect()->route('admin_user');
    }
}

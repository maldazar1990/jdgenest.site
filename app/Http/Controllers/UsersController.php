<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\HelperGeneral;
use App\Http\Forms\NewUserForm;
use App\Http\Forms\UserForm;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilder;

class UsersController extends Controller
{
    use PasswordValidationRules;

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
            $name = $file->getClientOriginalName();
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
        if($user->id == 1) {
            FacadesCache::forget('userInfo');
        }

        if ( $user->id == auth()->user()->id ) {
            return redirect()->route('admin_user');
        }
        return redirect()->route('admin_user')->with('message', 'emregistré avec succès');
    }
}

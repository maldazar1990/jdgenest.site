<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class NewUserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email',[
                "label" => "Email",
                "rules" => "required|string|email|max:255",
            ])
            ->add('name', 'text',[
                "label" => "Nom",
                "rules" => "required|string|max:255",
            ])
            ->add('password', 'password',[
                "label" => "Mot de passe",
                "rules" => "required|string|min:8|confirmed",
            ])
            ->add('Enregistrer', 'submit');
    }
}

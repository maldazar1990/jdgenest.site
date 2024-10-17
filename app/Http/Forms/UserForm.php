<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Nom',
                'rules' => 'required|max:255',
            ]);

            $this->add('email', 'email', [
                'label' => 'Email',
                'rules' => 'required|email',
            ]);
            $this->add('password', 'password', [
                'label' => 'Password',
                'rules' => 'required|min:6',
            ]);
            if( $this->model->hasRole('admin') ) {
                $this->add('jobTitle', 'text', [
                    'label' => 'Titre',
                    'rules' => 'required',
                ]);

                $this->add('presentation', 'textarea', [
                    'label' => 'Présentation',
                    'rules' => 'required',
                    "attr" => [
                        "class" => "form-control editor",
                        "id" => "editor",
                    ]
                ]);
                $this->add('image', 'file', [
                    'label' => 'Image',
                    'rules' => config("app.rule_image"),
                ]);
            }
            $this->add('Enregistrer', 'submit',[
                "label"=> 'Enregistrer',
            ]);

    }
}

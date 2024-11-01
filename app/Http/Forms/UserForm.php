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
            $this->add('password','password', [
                'label' => 'Password',
                'rules' => 'min:6',
		        'value'=>''
            ]);
            if( $this->model->hasRole('admin') ) {
                $this->add('jobTitle', 'text', [
                    'label' => 'Titre',
                    'rules' => 'required',
                ]);
                $this->add("presentation","hidden",[
                    "attr" => [
                        "id" => "quill-value",
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

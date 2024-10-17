<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                "label" => "Nom",
                'rules' => 'required | unique:roles,name | max:255',
            ])
            ->add('description', 'text', [
                "label" => "Description",
                'rules' => 'max:255',
            ])->add('submit', 'submit', [
                'label' => 'Enregistrer',
            ]);
    }
}

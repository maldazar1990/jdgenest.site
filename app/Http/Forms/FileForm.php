<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class FileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('image', 'file',[
                'label' => 'Image',
                'rules' => 'required|'.config("app.rule_image"),
            ])
            ->add('name', 'text',[
                'label' => 'Nom',
                'rules' => 'required | string | max:255',
            ])->add("submit", "submit", [
                "label" => "Enregistrer",
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ]);
    }
}

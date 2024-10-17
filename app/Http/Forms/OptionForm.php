<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class OptionForm extends Form
{
    public function buildForm()
    {

        $this
            ->add('option_name', 'text', [
                'label' => 'Option Name',
                'rules' => 'required | max:255 | unique:options_table,option_name',
            ])
            ->add('option_value', 'text', [
                'label' => 'Option Value',
                "attr" => [
                    "class" => "form-control",
                ],
            ])->add('submit', 'submit', [
                'label' => 'Enregistrer',
            ]);
    }
}

<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class TagForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => 'Titre',
                'rules' => 'required|max:255',
            ])
            ->add('Enregistrer', 'submit',[
                "label"=> 'Enregistrer',
            ]);
    }
}

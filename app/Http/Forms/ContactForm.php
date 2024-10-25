<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ContactForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('savon', 'text',[
                "label" => "Email",
                "rules" => "required|email",
                "attr" => [
                    "placeholder" => "Adresse Courriel",
                    "class" => "form-control input-lg mb-2"

                ]
            ]
            )
            ->add('name', 'text', [
                "label" => "Ton nom",
                "attr"=> [
                    "placeholder" => "Ton nom",
                    'class' => 'form-control input-lg mb-2'
                ],
                'rules' => 'required|min:3'
            ])
            ->add('text', 'textarea',[
                "label" => "Ton message",
                'attr' => [
                    'class' => 'form-control textarea h-25 mb-2',
                    'placeholder' => 'Message',
                    'rows' => 5,
                ],
                'rules' => 'required|min:10',

            ]);

    }
}

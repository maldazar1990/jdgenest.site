<?php

namespace App\Http\Forms;

use App\Tags;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Form;

class infosForm extends Form
{
    public function buildForm()
    {
        $tags = Tags::all()->pluck('title', 'id')->toArray();
        $selectedTags = [];
        $image = "";

        $hiddenTypeImage = "";

        if ($this->model){
            $image =   (str_contains($this->model->image,"http")?$this->model->image:null) ?? null;
            foreach($this->model->tags()->get() as $tag){
                $selectedTags[] = $tag->id;
            }
        }

        $this
            ->add('title', 'text',[
                "label" => "Titre",
                "rules" => "required|string|max:255",
            ])
            ->add('description', 'textarea',[
                "label" => "Description",
                "rules" => "string",
                "attr" => [
                    "class" => "form-control ckeditor",
                    "id" => "editor",
                ]
            ]);

            $this->add('image', 'file',[

                "label" => "Image",
                "rules" => config("app.rule_image"),
            ])
            ->add('imageUrl', 'url',[

                "label" => "ou url de l'Image",
                "rules" => "url",
                "value"=> $image,
            ])
            ->add("hiddenTypeImage","hidden",[
                "attr" => [
                    "id" => "hiddenTypeImage",
                ],
                "value"=>$this->model->image ?? null,
            ])
            ->add("link", "url",[
                "label" => "Lien",
                "rules" => "required|url|max:255",
            ])
            ->add('type', 'select',[
                "label" => "Type",
                "choices" => config("app.typeInfos"),
                "selected" => $this->model->type ?? "job",
                "rules" => "required",

            ])
            ->add('duree', 'number',[
                "label" => "Durée",
                'label_attr' => ['style' => 'display:none;'],
                'attr' => ['style' => 'display:none;'],

            ])
            ->add('datestart', 'date',[
                "label" => "Date de début",
                "rules" => "",
                "attr" => [
                    "required" => "required",

                ],
            ])
            ->add('dateend', 'date',[

                "label" => "Date de fin",
                "rules" => "",
            ]);
            $this->add('tags[]', 'select', [
                "multiple"=>"multiple",
                "choices" => $tags,
                "selected" => $selectedTags,
                "attr" => [
                    "class" => "select2 form-control",
                ],
                'label' => 'Tags',
            ]);

            $this->add("preselectedtags", "hidden",[
                "attr" => [
                    "id" => "preselectedtags",
                    "class" => "preselectedtags",
                ],
                "value" => implode(",", $selectedTags),
            ]);
            $this->add("submit","submit",[
                "label" => "Enregistrer",
                "attr" => [
                ]
            ]);
    }
}

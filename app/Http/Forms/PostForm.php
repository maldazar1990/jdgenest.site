<?php

namespace App\Http\Forms;

use App\HelperGeneral;
use App\Tags;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        $modelImage = $this->model->image ?? "";
        if ($modelImage) {
            if (str_contains($modelImage, ".")) {
                $imageName = explode(".", $modelImage);
                $imageName = $imageName[count($imageName) - 2];
            } else {
                $imageName = $this->model->image;
            }
        } else {
            $imageName = "";
        }
        $this
            ->add('title', 'text',[
                "label" => "Titre",
                "rules" => "required|string|max:255",
            ])
            ->add('post', 'textarea',[
                "label" => "Contenu",
                "rules" => "string",
                "attr" => [
                    "class" => "form-control ckeditor",
                    "id" => "editor",
                ]
            ]);

            $this->add('image', 'file',[
                "attr" => [
                    "placeholder"=>"Image",
                ],
                "rules" => config("app.rule_image"),
            ])->add('imageUrl', 'url',[
                "attr" => [
                    "placeholder"=>"Url de l'image",
                ],
                "rules" => "url",
                "value" => (Str::contains($modelImage, 'http')) ? $modelImage : null,
            ])
            ->add('selectImage', 'select',[

                "value" => $this->getData('image'),
                "attr"=>[
                    "placeholder"=>"Image",
                    "class"=>"form-control selectimage",
                ],
                "choices" => HelperGeneral::getImages(),
                'selected' => function ($data) use ($imageName,$modelImage ) {
                    // Returns the array of short names from model relationship data
                    return (Str::contains($modelImage, 'http')) ? null: $imageName;
                },
                'empty_value' => 'Choisir une image existante',
            ])
            ->add("hiddenTypeImage","hidden",[
                "attr" => [
                    "id" => "hiddenTypeImage",
                ],
                "value"=>"",
            ])
            ->add('status', 'select',[
                "label" => "Statut",
                "choices"=>array_filter(config("app.status"),function($val){
                    return $val != 2;
                },ARRAY_FILTER_USE_KEY),
            ]);
        $tags = Tags::all()->pluck('title', 'id')->toArray();
        $selectedTags = [];

        if ($this->model){
            foreach($this->model->tags()->get() as $tag){
                $selectedTags[] = $tag->id;
            }
        }

        $this->add('tags[]', 'select', [
            "multiple"=>"multiple",
            "choices" => $tags,
            //"selected" => $selectedTags,
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

        $this->add("submit", "submit", [
            "label" => "Enregistrer",
        ]);
    }
}

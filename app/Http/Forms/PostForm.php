<?php

namespace App\Http\Forms;

use App\HelperGeneral;
use App\Tags;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    
    protected $formOptions = [
        'method' => 'post',
        'id' => 'postForm',
    ];

    public function buildForm()
    {
        $modelImage = $this->model->image ?? "";
        
        $this
            ->add('title', 'text',[
                "label" => "Titre",
                "rules" => "required|string|max:255",
            ]);
 

            $this->add('image', 'file',[
                
                "attr" => [
                    "id"=>"imageUpload",
                ],
                "rules" => config("app.rule_image"),
            ])->add('imageUrl', 'url',[
                
                "attr" => [
                    "id"=>"imageUrl",
                ],
                "rules" => "url",
                "value" => (Str::contains($modelImage, 'http')) ? $modelImage : null,
            ])
           
            ->add("hiddenTypeImage","hidden",[
                "attr" => [
                    "id" => "hiddenTypeImage",
                ],
                "value"=>"",
            ])
            ->add('status', 'select',[
                "label" => "Statut",
                "class" => "form-control  mw-25",
                "choices"=>array_filter(config("app.status"),function($val){
                    return $val != 2;
                },ARRAY_FILTER_USE_KEY),
            ]);
       
        $this->add("submit", "submit", [
            "label" => "Enregistrer",
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\HelperGeneral;
use App\Http\Forms\PostForm;
use App\Page as page;
use App\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index()
    {
        $dataProvider = new EloquentDataProvider(page::query()->where("status","!=",2)->orderBy('created_at', 'desc'));
        return view('admin.index', [

            "title" => "Pages",
            "gridviews" => [
                "dataProvider" => $dataProvider,
                'title' => "liste des pages",
                'columnFields' => [
                    [
                        "label" => "Titre",
                        'format' => 'html',
                        "value" => function ($model) {
                            return "<a href=\"".route("post",$model->slug)."\">".Str::limit($model->title, 50)."</a>";
                        },
                    ],
                    [
                        "label" => "Status",
                        "value" => function ($data) {
                            return config("app.status")[$data->status];
                        },
                    ],
                    [
                        'label' => 'Image', // Column label.
                        'filter' => false, // If false, then column will be without a search filter form field.
                        "value" => function ($row) {
                            if (!Str::contains($row->image, 'http') and $row->image) {
                                $filename = explode('.', $row->image)[0]."_small.webp";
                                return asset('images/' . $filename);
                            }else if (Str::contains($row->image, 'http')) {
                                return $row->image;
                            } else {
                                return asset('images/default.jpg');
                            }
                        },
                        'format' => [ // Set special formatter. If $row->icon value is a url to image, it will be inserted in to 'src' attribute of <img> tag.
                            'class' => \Itstructure\GridView\Formatters\ImageFormatter::class, // REQUIRED. For this case it is necessary to set 'class'.
                            'htmlAttributes' => [ // Html attributes for <img> tag.
                                'width' => '100',

                            ],

                        ]
                    ],
                    [
                        "label"=>"Date de création",
                        "value" => function ($model) {
                            return $model->created_at;
                        },
                    ],
                    [
                        "label" => "Action",

                        "htmlAttributes" => [
                            "width" => "25%",
                        ],
                        'class' => \Itstructure\GridView\Columns\ActionColumn::class,
                        'actionTypes' => [

                            'edit' => function ( $data) {
                                return route('admin_page_edit',$data->id);
                            },
                            'delete' => function ($data) {
                                return route('admin_page_delete',$data->id);
                            },

                        ]
                    ]

                ],
            ],
        ]);
    }

    /**
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request, FormBuilder $formBuilder) {
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route("admin_page_insert"),
        ]);

        return view("admin.editWithImage",[
            "title" => "Publier une page",
            "form"  => $form,
        ]);
    }

    public function rules (  ) {
        return array(

            'title' => "required|max:255",
            "image" => config("app.rule_image"),
            "post" => "required",
            "tags" => "required",
            "status"=>"required|in:0,1,2",

        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = $this->rules();
        $rules["title"] = $rules["title"] . "|unique:post,title";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin_page_create')
                ->withErrors($validator)
                ->withInput();
        }
        $page = new page();

        if ( $request->file("image") ) {
            $file = $request->file("image");
            $name = Str::slug(time() . $file->getClientOriginalName());
            $file->move(public_path("images"), $name);
            HelperGeneral::createNewImage($name);
            $page->image = $name;
        } else  if ( $request->imageUrl ) {
            HelperGeneral::deleteImage($page->image);
            $page->image = $request->imageUrl;
        } else if ( $request->selectImage ) {
            $page->image = $request->selectImage.".webp";
        }

        $page->title = $request->input("title");
        $page->post = $request->input("post");
        $page->slug = Str::slug($page->title,"-");
        $page->status = $request->input("status");
        $page->user_id = Auth::user()->id;
        $page->type = config("app.typePost.post");
        $page->save();
        $request->session()->flash('message', 'Enregistré avec succès');
        return redirect()->route('admin_page');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FormBuilder $formBuilder, $id)
    {
        $pages = post::where( 'id', $id )->first();
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route('admin_page_update', $id),
            'model' => $pages,
        ]);


        return view("admin.editWithImage",[
            "title" => "Modifier une publication",
            "form" => $form,
            "model" => $pages,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $page = page::where( 'id', $id )->first();
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('admin_page_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        if ( $request->file("image") ) {
            HelperGeneral::deleteImage($page->image);
            $file = $request->file("image");
            $name = Str::slug(time() . $file->getClientOriginalName());
            $file->move(public_path("images"), $name);
            HelperGeneral::createNewImage($name);
            $page->image = $name;
        } else if ( $request->imageUrl ) {
            HelperGeneral::deleteImage($page->image);
            $page->image = $request->imageUrl;
        } else if ( $request->selectImage ) {
            $page->image = $request->selectImage.".webp";
        }
        $page->title = $request->input("title");
        $page->post = $request->input("post");
        $page->status = $request->input("status");
        $page->slug = Str::slug($page->title,"-");
        $page->save();
        $request->session()->flash('message', 'Enregistré avec succès');
        return redirect()->route('admin_page');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pages = post::where( 'id', $id )->first();
        $pages->status = 2;
        $pages->save();
        $request->session()->flash('message', 'Supprimé avec succès');
        return redirect()->route('admin_page');
    }
}

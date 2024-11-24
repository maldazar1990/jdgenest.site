@extends('admin.layouts.app')
@section("content")
    <div class="col-12">
        <div class="card mb-4">
            @include("toolbox.error")
            <div class="card-block">
                <form id="adminForm" method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-lg-9">
                            @if ( isset($model) )
                                <h5>image actuel</h5><br>
                                @include("toolbox.image", ['image' => $model->file,"class" => "img-fluid mb-4","size"=>"medium"])
                            @else
                                <img src="images/default.webp" id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3 d-none'>
                            @endif
                            @php
                                $attributes = config("custom.defaultHtmlFile");
                            @endphp
                            @include("toolbox.input",["inputName"=>"image", "inputId"=>"imageUpload", "inputFieldName"=>"Image","inputType"=>"file","inputClass"=>"","model"=>$model,"attributes"=>$attributes])
                            @include("toolbox.input",["inputName"=>"name","inputFieldName"=>"nom","inputType"=>"text","inputClass"=>"","model"=>$model,
                                "attributes"=>[
                                    "required"=>"required",
                                    "minlength"=>5,
                                    "maxlength"=>config("custom.maxlength"),
                                    "data-model"=>"files",
                                ]
                            ])
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
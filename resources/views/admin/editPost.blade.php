@extends('admin.layouts.app')
@section("content")
    <div class="col-12">
        <div class="card mb-4">
            @include("toolbox.error")
            <div class="card-block">
                @if ( isset($model) )
                <h3 class="card-title"><a href="{{route("post",$model->slug)}}">{{$title}}</a></h3>
                @endif
                <form id="adminForm" method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-lg-9">
                            @if ( isset($model) )

                                @include("toolbox.image", ['modelWithImage' => $model,"class" => "img-fluid mb-4","size"=>"medium"])

                            @else
                                <img src="{{asset(config("custom.default"))}}" id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3 d-none'>

                            @endif
                            @include("toolbox.input",["inputName"=>"title","inputFieldName"=>"Titre","inputType"=>"text","inputClass"=>"","model"=>$model,
                                "attributes"=>[
                                    "minlength"=>5,
                                    "maxlength"=>config("custom.maxlength"),
                                    "required"=>"required",
                                    "data-model"=>"posts",
                            ]])
                            @include("toolbox.textarea",["inputName"=>"post","inputFieldName"=>"Publication","model"=>$model])
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-image-upload" data-toggle="tab" data-target="#nav-upload" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader l'image</button>

                                    <button class="nav-link " id="nav-image-url" data-toggle="tab" data-target="#nav-url" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Image en ligne</button>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade active show p-1" id="nav-upload" role="tabpanel" aria-labelledby="nav-image-upload">
                                    @php
                                        $attributes = config("custom.defaultHtmlFile");

                                        $alreadyRequired = true;

                                        if( isset($model) ){
                                            unset($attributes["required"]);
                                            $alreadyRequired = false;
                                        }

                                        $inputImageParam = [ "haveLabel"=>false, "inputName"=>"image", "inputId"=>"imageUpload", "inputFieldName"=>"Image","inputType"=>"file",
                                        "inputClass"=>"",
                                        "model"=>$model,
                                        "attributes"=>$attributes];
                                    @endphp
                                    @include("toolbox.input",$inputImageParam)
                                </div>

                                <div class="tab-pane fade p-1 " id="nav-url" role="tabpanel" aria-labelledby="nav-image-url">
                                    @php
                                        $inputImageParam = [ "haveLabel"=>false,"inputName"=>"imageUrl","inputFieldName"=>"Images","inputType"=>"url","inputClass"=>"","model"=>$model,"attributes"=>[]];
                                        if($alreadyRequired == false) {
                                            if( !isset($model) ) {
                                                if(!empty($model->imageUrl)){

                                                    $inputImageParam["attributes"]["required"] = "required";
                                                }
                                            }
                                        }

                                    @endphp
                                    @include("toolbox.input",$inputImageParam)

                                </div>

                            </div>
                            @include("toolbox.SelectInput",["inputName"=>"status","inputFieldName"=>"Status","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"] ,"inputAllValues"=>config("app.status")])
                            @include("toolbox.SelectInput",["inputName"=>"tags","inputFieldName"=>"Tags","inputClass"=>"select2","model"=>$model,"attributes"=>["required"=>"required","multiple"=>"multiple"] ,"inputAllValues"=>$tags->pluck("title","id")])
                            @include("toolbox.input",["inputName"=>"created_at","inputFieldName"=>"Date de publication","inputType"=>"date","inputClass"=>"","inputDefaultValue"=>\Carbon\Carbon::now()->format("Y-m-d"),"model"=>$model,
                                "attributes"=>[
                                    "required"=>"required",
                                    "min"=>\Carbon\Carbon::now()->format("Y-m-d"),
                            ]])
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

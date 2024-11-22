@extends('admin.layouts.app')

@section("content")

    <div class="col-12">
        <div class="card mb-4">
            @include("toolbox.error")
            <div class="card-block">
                <h3 class="card-title">{{$title}}</h3>
                <form id="adminForm" method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf


                    @if ( isset($info) )
                        <h5>image actuel</h5><br>
                        @include("toolbox.image", ['modelWithImage' => $info,"class" => "img-fluid mb-4","size"=>"medium"])
                    @else
                        <img src="images/default.webp" id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3 d-none'>

                    @endif
                    @include("toolbox.input",["inputName"=>"title","inputFieldName"=>"Titre","inputType"=>"text","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required"]])
                    @include("toolbox.textarea",["inputName"=>"description","inputFieldName"=>"Description","model"=>$info])
                    @include("toolbox.SelectInput",["inputName"=>"type","inputFieldName"=>"Type d'expérience:","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required"] ,"inputAllValues"=>config("app.typeInfos")])
                    @include("toolbox.input",["inputName"=>"link","inputFieldName"=>"Liens","inputType"=>"url","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required"]])
                    <fieldset class="mb-3">
                        <legend>Temps</legend>
                        <div class="row">
                            <div class="col-6">
                                @include("toolbox.input",["inputName"=>"datestart","inputFieldName"=>"Date de début","inputType"=>"date","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required"]])
                            </div>
                            <div class="col-6">
                                @include("toolbox.input",["inputName"=>"dateend","inputFieldName"=>"Date de fin","inputType"=>"date","inputClass"=>"","model"=>$info])
                            </div>
                        </div>
                    </fieldset>
                    @include("toolbox.input",["inputName"=>"image", "inputId"=>"imageUpload", "inputFieldName"=>"Image","inputType"=>"file","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required","accept"=>"image/*"]])
                    @include("toolbox.SelectInput",["inputName"=>"tags","inputFieldName"=>"Tags","inputClass"=>"select2","model"=>$info,"attributes"=>["required"=>"required","multiple"=>"multiple"] ,"inputAllValues"=>$tags->pluck("title","id")])
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
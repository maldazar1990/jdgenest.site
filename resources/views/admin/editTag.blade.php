@extends('admin.layouts.app')
@section("content")
    <div class="col-12">
        <div class="card mb-4">
            @include("toolbox.error")
            <div class="card-block">

                <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-lg-9">

                            @include("toolbox.input",["inputName"=>"title","inputFieldName"=>"Titre","inputType"=>"text","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"]])
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

@extends('admin.layouts.app')

@section("content")

@php
    if (old("datestart")){
        $datestart = old("datestart");
    } else if (isset($info)){
        $datestart = substr($info->datestart,0,10);
    } else {
       $datestart = "";
    }

    if (old("dateend")){
       $dateend = old("dateend");
    } else if (isset($info)){
        $dateend = substr($info->dateend,0,10);
    } else {
       $dateend = "";
    }

@endphp
    <div class="col-12">
        <div class="card mb-4">
            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-block">
                <h3 class="card-title">{{$title}}</h3>
                <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @if($info)
        
                            @php
                                $image = $info->image;
                                if (!str_contains($info->image,'http')) 
                                    $image = URL::to('/')."/images/".$info->image;
                            @endphp
                            <img src="{{ $image }}" class="img-fluid" alt="">
                        @endif
                    </div>
                    @include("toolbox.input",["inputName"=>"title","inputFieldName"=>"Titre","inputType"=>"text","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required"]])
                    <div class="relative mb-5" wire:ignore>
                        <script>
                            const valpost = "{!! isset($info)?addslashes($info->description):'' !!}";
                        </script>
                        @error('description')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                        <label for="quill-editor" class="control-label   ">Post</label>
                        <div id="quill-editor" class="mb-3 @error('post')error   @enderror" style="height: 700px;"></div>
                    </div>
                    @include("toolbox.input",["inputName"=>"description","inputId"=>"quill-value", "inputType"=>"hidden","inputClass"=>"","model"=>$info)
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

                    @include("toolbox.input",["inputName"=>"file","inputFieldName"=>"Image","inputType"=>"file","inputClass"=>"","model"=>$info,"attributes"=>["required"=>"required","accept"=>"image/*"]])
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select class="form-select select2" id="tags" name="tags[]" multiple required>
                            @php
                                $selectedTags = [];
                                if(old("tags")){
                                    $selectedTags = old("tags");
                                } else if($info){
                                    $selectedTags = $info->tags->pluck("id")->toArray();
                                }
                            @endphp
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" @if(in_array($tag->id,$selectedTags)) selected @endif>{{ $tag->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
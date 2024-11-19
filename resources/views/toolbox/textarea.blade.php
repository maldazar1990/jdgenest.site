@php

if (!isset($inputName)){
    dd("manque le nom du champ");
}

if(old($inputName)){
    $value = old($inputName);
} else {
    if ( isset($model)){
        if ( isset($model->{$inputName}) ){
            $value = addslashes($model->{$inputName});
        } else {
            $value = "";
        }
    } else {
        if ( !isset($value) ) {
            $value = "";
        }
    }
}

if (!isset($inputFieldName)){
    dd("manque le nom du champ");
}


@endphp
<div class="relative mb-5">
    <script>
        const valpost = `{!! $value !!}`;
    </script>

    <label for="quill-editor" class="control-label @error($inputName) is-invalid @enderror  ">{{$inputFieldName}}</label>
    <div id="quill-editor" class="mb-3 @error($inputName) is-invalid @enderror" style="height: 700px;"></div>
    @error($inputName)
    <div class="invalid-feedback">{{ $errors->first($inputName) }}</div>
    @enderror
</div>
@include("toolbox.input",["inputName"=>$inputName,"inputId"=>"quill-value", "inputType"=>"hidden","inputClass"=>"","model"=>$model])

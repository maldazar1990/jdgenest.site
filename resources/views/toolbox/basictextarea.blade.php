@php

if (!isset($inputName)){
    dd("manque le nom du champ");
}

if(!isset($model)) {
    $model = null;
}

if(old($inputName)){
    $value = old($inputName);
} else {
    if ( isset($model)){
        if ( isset($model->{$inputName}) ){
            $value = $model->{$inputName};
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

$inputAttributes = "";
if (isset($attributes)){
    foreach( $attributes as $key => $content){
        $inputAttributes .= $key.'="'.$content.'" ';
    }
}

@endphp
<div class="relative mb-3">
    <label for="quill-editor" class="control-label @error($inputName) is-invalid @enderror  ">{{$inputFieldName}}</label>
    <textarea id="{{$inputName}}" name="{{$inputName}}" class="form-control" {{$inputAttributes}} style="height: 200px;">{{$value}}</textarea>
    @error($inputName)
    <div class="invalid-feedback">{{ $errors->first($inputName) }}</div>
    @enderror
</div>
@php
    unset($inputAttributes);
    unset($inputName);
    unset($inputFieldName);
    unset($value);
@endphp

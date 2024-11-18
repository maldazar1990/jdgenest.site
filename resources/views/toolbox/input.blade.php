
@php

if (!isset($inputName)){
    dd("manque le nom du champ");
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
        if ( isset($value) ){
            $value = $value;
        } else {
            $value = "";
        }
    }
}


if(!isset($inputClass)){
    $inputClass = "";
}

$id = $inputName;
if ( isset($inputId) )
    $id = $inputId;



if(!isset($inputType)){
    $inputClass = "text";
} else {
    if (in_array($inputType, ["text","email","password","number","url","tel","date","time","datetime-local","month","week","search","color","range","file","hidden","image"])){
        $inputType = $inputType;
    } else {
        $inputType = "text";
    }
}

if (!isset($inputFieldName) and $inputType != "hidden"){
    dd("manque le nom du champ");
}

$inputAttributes = "";
if (isset($attributes)){
    foreach( $attributes as $key => $content){

        if ($inputType == "file" and $key == "required" and isset($model->{$inputName})){
            continue;
        } else {
            $inputAttributes .= $key.'="'.$content.'" ';
        }


    }
} else {
    $inputAttributes = "";
}

@endphp

<div class="mb-3">
    @error($inputName)
    <div style="color:red;">{{ $errors->first($inputName) }}</div>
    @enderror
    <label for="{{$inputName}}" class="form-label ">{{$inputFieldName}}</label>
    <input type="{{$inputType}}" {{$inputAttributes}}  class="form-control {{$inputClass}}" id="{{$id}}" name="{{$inputName}}" value="{{ $value }}">
</div>

@php
    unset($inputName);
    unset($inputType);
    unset($inputClass);
    unset($inputAttributes);
    unset($value);
    unset($inputFieldName);
    unset($inputId);
@endphp
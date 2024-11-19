
@php

    if (!isset($inputName)){
        dd("manque le nom du champ");
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
        if (!in_array($inputType, ["text","email","password","number","url","tel","date","time","datetime-local","month","week","search","color","range","file","hidden","image"])){
            dd("mauvais type");
        }
    }

    if (!isset($inputFieldName) and $inputType != "hidden"){
        dd("manque le nom du champ");
    }
    if ($inputType == "hidden"){
        $inputFieldName = "";
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
    }

    if(old($inputName)){
        $value = old($inputName);
    } else {
        if ( isset($model)){
            if ( isset($model->{$inputName}) ){
                if ( $inputType == "date" )
                    $value = \Carbon\Carbon::parse($model->{$inputName})->format('d/m/Y');
                else
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

@endphp
@if( $inputType != "hidden")
<div class="mb-3">
    <label for="{{$inputName}}" class="form-label ">{{$inputFieldName}}</label>
    <input type="{{$inputType}}" {{$inputAttributes}}  class="form-control {{$inputClass}} @error($inputName) is-invalid @enderror" id="{{$id}}" name="{{$inputName}}" value="{{ $value }}">
    @error($inputName)
    <div class="invalid-feedback">{{ $errors->first($inputName) }}</div>
    @enderror
</div>
@else
    <input type="{{$inputType}}" {{$inputAttributes}}  class="form-control {{$inputClass}} @error($inputName) is-invalid @enderror" id="{{$id}}" name="{{$inputName}}" value="{{ $value }}">
@endif
@php
    unset($inputName);
    unset($inputType);
    unset($inputClass);
    unset($inputAttributes);
    unset($value);
    unset($inputFieldName);
    unset($inputId);
@endphp
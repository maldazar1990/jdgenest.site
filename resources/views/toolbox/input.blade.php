
@php

    if (!isset($inputName)){
        dd("manque le nom du champ");
    }

    if(!isset($haveLabel)) {
        $haveLabel = true;
    }

    if(!isset($model)) {
        $model = null;
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
            if (in_array($inputType,['file','password']) and $key == "required" and isset($model->{$inputName})){
                continue;
            } else {
                $inputAttributes .= $key."=".$content." ";
            }



        }
    }

    if(old($inputName)){
        $value = old($inputName);
    } else {
        if($inputType != "password"){
            if ( isset($model)){
                if ( isset($model->{$inputName}) ){
                    if ( $inputType == "date" )
                        $value = \Carbon\Carbon::parse($model->{$inputName})->format('Y-m-d');
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
        } else {
            $value="";
        }

        if ($value == "") {
            if ( isset($inputDefaultValue) ){
                $value = $inputDefaultValue;
            }
        }
    }


    $leurreClass = "";
    $leurreFieldClass = "";
    $leurreInputClass = "";
    if ( isset($leurre)){
        if ($leurre) {
            $leurreClass = "fieldForm";
            $leurreInputClass = "fieldInput";
            $leurreFieldClass = "fieldFormClass";
        }
    }

@endphp
@if( $inputType != "hidden")
@if($leurreClass)
<style>
    .{{$leurreClass}} {
        position: absolute; top: -9999px; left: -9999px;
    }
    .{{$leurreInputClass}} {
        position: absolute; top: -9999px; left: -9999px;
    }
</style>
@endif
<div class="mb-3 {{$leurreClass}}">
    @if($haveLabel)
        <label for="{{$inputName}}" class="form-label {{$leurreInputClass}}">{{$inputFieldName}}</label>
    @endif
    <input type="{{$inputType}}" {{$inputAttributes}}  class="form-control {{$inputClass}} @error($inputName) is-invalid @enderror {{$leurreFieldClass}} {{$leurreInputClass}}" id="{{$id}}" name="{{$inputName}}" value="{{ $value }}">
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
    unset($haveLabel);
    unset($leurre);
    unset($leurreClass);
    unset($leurreFieldClass);
    unset($leurreInputClass);
@endphp

@php

    if (!isset($inputName)){
        dd("manque le nom du champ");
    }

    if ( !isset($inputAllValues) ) {
        dd("manque les valeurs");
    }

    if (!isset($inputFieldName)){
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
            if ( isset($value) ) {
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
        if (!in_array($inputType, ["radio","checkbox"])) {
            dd("mauvais type");
        }
    }

    $inputAttributes = "";

    if (isset($attributes)){
        foreach( $attributes as $key => $content){
            $inputAttributes .= $key.'="'.$content.'" ';
        }
    }
@endphp

<div class="mb-3">
    <fieldset class="mb-3">
        <legend>{{$inputFieldName}}</legend>
        @foreach($inputAllValues as $key => $inputValue)
            <div class="form-check">
                <input class="form-check @error($inputName) is-invalid @enderror" type="{{$inputType}}" {{$inputAttributes}}  class="form-check" id="{{$inputName}}_{{$key}}" name="{{$inputName}}" value="{{ $key }}" @if($value == $key) checked @endif>
                <label class="form-check   " for="{{$inputName}}_{{$key}}">
                    {{$inputValue}}
                </label>
            </div>
        @endforeach
    </fieldset>
    @error($inputName)
    <div class="invalid-feedback">{{ $errors->first($inputName) }}</div>
    @enderror
</div>

@php
    unset($inputName);
    unset($inputType);
    unset($inputClass);
    unset($inputAttributes);
    unset($value);
    unset($inputAllValues);
    unset($inputFieldName);
    unset($inputId);
@endphp

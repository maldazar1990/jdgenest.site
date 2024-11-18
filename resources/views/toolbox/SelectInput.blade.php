@php

    if (!isset($inputFieldName)){
        dd("manque le nom du champ");
    }

    if (!isset($inputName)){
        dd("manque le nom du champ");
    }

    if ( !isset($inputAllValues) ) {
        dd("manque les valeurs");
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


    $inputAttributes = "";


    $id = $inputName;
    if ( isset($inputId) )
        $id = $inputId;

    if (isset($attributes)){
        foreach( $attributes as $key => $content){
            $inputAttributes .= $key.'="'.$content.'" ';
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
    <select class="form-select {{$inputClass}}" id="{{$id}}" name="{{$inputName}}" {{$inputAttributes}}>
        @foreach($inputAllValues as $key => $inputValue)
            <option value="{{ $key }}" @if($value == $key) selected @endif>{{ $inputValue }}</option>
        @endforeach
    </select>
</div>

@php
    unset($inputName);
    unset($inputClass);
    unset($inputAttributes);
    unset($value);
    unset($inputAllValues);
    unset($inputFieldName);
    unset($inputId);
@endphp


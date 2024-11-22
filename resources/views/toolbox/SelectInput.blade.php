@php

    if (!isset($inputFieldName)){
        dd("manque le nom du champ");
    }

    if(!isset($model)) {
        $model = null;
    }
    if (!isset($inputName)){
        dd("manque le nom du champ");
    }

    if ( !isset($inputAllValues) ) {
        dd("manque les valeurs");
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
    }

    $isMultiple = false;
    $addName="";
    if ( array_key_exists("multiple",$attributes) ){
        $isMultiple = true;
        $addName = "[]";
    }


    if(old($inputName)){
        $value = old($inputName);
    } else {
        if ( isset($model)){
            if ( isset($model->{$inputName}) ){
                if($isMultiple)
                    $value = $model->{$inputName}->pluck("id")->toArray();
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

<div class="mb-3">
    <label for="{{$inputName}}" class="form-label ">{{$inputFieldName}}</label>
    <select class="form-select {{$inputClass}} @error($inputName) is-invalid @enderror" id="{{$id}}" name="{{$inputName.$addName}}" {{$inputAttributes}}>
        @foreach( $inputAllValues as $key => $content )
            <option value="{{ $key }}"
            <?php

                if (isset($model)) {
                    if ($isMultiple) {
                        if (in_array($key, $value)) {
                            echo "selected";
                        }
                    } else {
                        if ($value == $key) {
                            echo "selected";
                        }
                    }
                }

            ?>
            >{{ $content }}</option>
        @endforeach
    </select>
    @error($inputName)
    <div class="invalid-feedback">{{ $errors->first($inputName) }}</div>
    @enderror
</div>

@php
    unset($inputName);
    unset($inputClass);
    unset($inputAttributes);
    unset($value);
    unset($inputAllValues);
    unset($inputFieldName);
    unset($inputId);
    unset($isMultiple);
    unset($addName);
@endphp


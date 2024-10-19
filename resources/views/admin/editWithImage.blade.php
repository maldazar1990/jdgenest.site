@extends('admin.layouts.app')

@section("content")

    <div class="col-12">
        <div class="card mb-4">
            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
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
                @php
                    echo form_start($form);

                    $fieldName = "post";
                    if ($form instanceof App\Http\Forms\infosForm)
                        $fieldName = "description";

                    echo form_until($form, $fieldName);
                    $typeImage = 2;
                    if( isset($model) ) {
                        if ($model->image) {
                            $image = "";
                            if (Str::contains($model->image, 'http')) {

                                if (App\HelperGeneral::urlValide($model->image)) {
                                    $image = $model->image;
                                } else {
                                    dd(1);
                                }

                                    
                                
                                $typeImage = 0;
                            } else {
                                $filename = explode('.', $model->image);
                                $image = asset("images/" .$filename[0]."_small.webp");

                                if($form instanceof App\Http\Forms\PostForm) {
                                    $lstImage = App\HelperGeneral::getImages();

                                    if ( in_array($model->image, $lstImage) ) {
                                        $typeImage = 1;
                                    } else {
                                        $typeImage = 2;
                                    }
                                } else {
                                    $typeImage = 2;
                                }

                            }
                            if ($image) {
                                echo "
                                    <h5>image actuel</h5>
                                    <img src='".$image."' alt='image actuel' width='200px' class='img-fluid mb-3'>
                                ";
                            }
                        }

                    }
                @endphp
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link {{$typeImage==2?"active":""}}" id="nav-image-upload" data-toggle="tab" data-target="#nav-upload" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader l'image</button>
                        @if($form instanceof App\Http\Forms\PostForm)
                        <button class="nav-link {{$typeImage==1?"active":""}}" id="nav-image-select" data-toggle="tab" data-target="#nav-select" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Sélectionner une image existante</button>
                        @endif
                        <button class="nav-link {{$typeImage==0?"active":""}}" id="nav-image-url" data-toggle="tab" data-target="#nav-url" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Image en ligne</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade  {{$typeImage==2?"active show":""}} p-1" id="nav-upload" role="tabpanel" aria-labelledby="nav-image-upload">
                        {!! form_widget($form->image) !!}
                    </div>
                    @if($form instanceof App\Http\Forms\PostForm)
                    <div class="tab-pane fade p-1 {{$typeImage==1?"active show":""}}" id="nav-select" role="tabpanel" aria-labelledby="nav-image-select">
                        {!! form_widget($form->selectImage) !!}
                    </div>
                    @endif
                    <div class="tab-pane fade p-1 {{$typeImage==0?"active show":""}}" id="nav-url" role="tabpanel" aria-labelledby="nav-image-url">
                        {!! form_widget($form->imageUrl) !!}
                    </div>
                </div>

                @php
                    echo form_rest($form);
                    echo form_end($form);
                @endphp
            </div>
        </div>
    </div>
@endsection

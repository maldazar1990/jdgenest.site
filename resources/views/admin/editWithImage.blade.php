@extends('admin.layouts.app')

@section("content")
@php

    $typeImage = 2;
    if( isset($model) ) {
        if ($model->image) {
            $image = "";
            if (Str::contains($model->image, 'http')) {

                if (App\HelperGeneral::urlValide($model->image)) {
                    $image = $model->image;
                } 
                
                $typeImage = 0;
            } else {
                $dbImage = App\Image::find($model->image_id);
                if ($model->image_id)  {
                    
                    if ($dbImage) {

                        if (Str::contains($dbImage->file, 'images/')) {
                            $image = asset($dbImage->file);
                        } else {
                            $image = asset("images/" . $dbImage->file);
                        }

                        $typeImage = 1;
                    }
                } else {
                    if (Str::contains($dbImage->file, 'images/')) {
                        $image = asset($dbImage->file);
                    } else {
                        $image = asset("images/" .$model->image);
                    }
                    $typeImage = 2;
                }
            }
                
        }
    }

@endphp


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
                    {!! form_start($form) !!}
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12 col-lg-9">
                            @if ( isset($image) )
                                <h5>image actuel</h5><br>
                                <img src='{{$image}}' id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3'>
                            @endif

                            

                            <div class="form-group">
                                <label for="title" class="control-label">Titre</label>
                                {!! form_widget($form->title) !!}
                            </div>
                            <div class="relative mt-4" wire:ignore>
                                <script>
                                    const valpost = "{!! isset($model)?addslashes($model->post):'' !!}";
                                </script>
                                <label for="default-search" class="class="control-label">Post</label>
                                <div id="quill-editor" class="mb-3 @error('post')error   @enderror" style="height: 700px;"></div>
                                <textarea rows="15" class="mb-3 d-none"  id="quill-editor-area"></textarea>                    
                            </div>
                            <input type="hidden" name="post" id="quill-value" value="">

                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-image-upload" data-toggle="tab" data-target="#nav-upload" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader l'image</button>
                                    @if($form instanceof App\Http\Forms\PostForm)
                                    @endif
                                    <button class="nav-link " id="nav-image-url" data-toggle="tab" data-target="#nav-url" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Image en ligne</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade active show p-1" id="nav-upload" role="tabpanel" aria-labelledby="nav-image-upload">
                                    {!! form_widget($form->image) !!}
                                </div>
                                @if($form instanceof App\Http\Forms\PostForm){{--

                                --}}@endif
                                <div class="tab-pane fade p-1 " id="nav-url" role="tabpanel" aria-labelledby="nav-image-url">
                                    {!! form_widget($form->imageUrl) !!}
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label for="status" class="control-label">Status</label>
                                {!!  form_widget($form->status) !!}
                            </div>
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

@extends('admin.layouts.app')

@section("content")
@php
    if (old("title")){
        $title = old("title");
    } else if (isset($model)){
        $title = $model->title;
    } else {
        $title = "";
    }

    if (old("post")){
        $post = old("post");
    } else if (isset($model)){
        $post = addslashes($model->post);
    } else {
        $post = "";
    }

    if (old("created_at")){
        $created_at = old("created_at");
    } else if (isset($model)){
        $created_at = $model->created_at->format("Y-m-d");
    } else {
        $created_at = carbon()->now()->format("Y-m-d");
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


                @if ( isset($model) )
                <h3 class="card-title"><a href="{{route("post",$model->slug)}}">{{$title}}</a></h3>
                @endif
                    {!! form_start($form) !!}
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12 col-lg-9">
                            @if ( isset($image) )
                                <h5>image actuel</h5><br>
                                @include("toolbox.image", ['image' => $image,"class" => "img-fluid mb-4","size"=>"medium"])
                            @else
                                <h5>image actuel</h5><br>
                                <img src="images/default.webp" id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3 d-none'>

                            @endif

                            

                            <div class="form-group">
                                <label for="title" class="control-label">Titre</label>
                                <input type="text" class="form-control   " id="title" name="title" value="{{$title}}" required>
                            </div>
                            <div class="relative mt-4" wire:ignore>
                                <script>
                                    const valpost = `{!! $post !!}`;
                                    console.log(valpost);
                                </script>
                                <label for="default-search" class="control-label">Post</label>
                                <div id="quill-editor" class="mb-3 @error('post')error   @enderror" style="height: 700px;"></div>
                                <textarea rows="15" class="mb-3 d-none"  id="quill-editor-area"></textarea>                    
                            </div>
                            <input type="hidden" name="post" id="quill-value" value="">

                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-image-upload" data-toggle="tab" data-target="#nav-upload" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader l'image</button>

                                    <button class="nav-link " id="nav-image-url" data-toggle="tab" data-target="#nav-url" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Image en ligne</button>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade active show p-1" id="nav-upload" role="tabpanel" aria-labelledby="nav-image-upload">
                                    {!! form_widget($form->image) !!}
                                </div>

                                <div class="tab-pane fade p-1 " id="nav-url" role="tabpanel" aria-labelledby="nav-image-url">
                                    {!! form_widget($form->imageUrl) !!}
                                </div>

                            </div>
                            <div class="form-group mt-4">
                                <label for="status" class="control-label">Status</label>
                                {!!  form_widget($form->status) !!}
                            </div>
                            <div class="mb-3">
                                 @php
                                    
                                @endphp
                                <label for="tags" class="form-label">Tags</label>
                                <select class="form-select select2" id="tags" name="tags[]" multiple required>
                                   
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" @if(in_array($tag->id,$selectedTags)) selected @endif>{{ $tag->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category" class="control-label">Date de publication</label>
                                <input type="date" class="form-control" name="created_at" value="{{ $created_at }}" required>
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

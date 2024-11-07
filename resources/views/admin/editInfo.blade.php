@extends('admin.layouts.app')

@section("content")

    


    <div class="col-12">
        <div class="card mb-4">
            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
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
                <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @if($info)
        
                            @php
                                $image = $info->image;
                                if (!str_contains($info->image,'http')) 
                                    $image = URL::to('/')."/images/".$info->image;
                            @endphp
                            <img src="{{ $image }}" class="img-fluid" alt="">
                        @endif
                    </div>
                    <div class="mb-3">
                        @error('title')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                        <label for="title" class="form-label   ">Titre</label>
                        <input type="text" class="form-control   " id="title" name="title" value="{{ old("title")??$info->title??"" }}" required>
                    </div>
                    <div class="relative mb-5" wire:ignore>
                        <script>
                            const valpost = "{!! isset($info)?addslashes($info->description):'' !!}";
                        </script>
                        @error('description')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                        <label for="quill-editor" class="control-label   ">Post</label>
                        <div id="quill-editor" class="mb-3 @error('post')error   @enderror" style="height: 700px;"></div>
                    </div>
                    <input type="hidden" name="description" id="quill-value" value="{{old("description")??""}}">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'expérience:</label>
  
                        @php
                        $currentType = old("type")??$info->type??"";
                        @endphp

                        <select class="form-select" id="type" name="type">
                            @foreach( config("app.typeInfos") as $key => $type)
                                
                            
                                <option value="{{ $key }}" @if($currentType == $key) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        @error('link')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                        <label for="link" class="form-label ">Lien</label>
                        <input type="url" class="form-control" id="link" name="link" value="{{ old("link")??$info->link??"" }}" required>
                    </div>

                    <fieldset class="mb-3">
                        <legend>Temps</legend>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    @error('datestart')
                                        <div style="color:red;">{{ $message }}</div>
                                    @enderror
                                    <label for="datestart" class="form-label  ">Date de début</label>
                                    <input type="date" class="form-control  " id="datestart" name="datestart" value="{{  old("datestart")??substr($info->datestart,0,10)??"" }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    @error('dateend')
                                        <div style="color:red;">{{ $message }}</div>
                                    @enderror
                                    <label for="dateend" class="form-label  ">Date de fin</label>
                                    <input type="date" class="form-control  " id="dateend" name="dateend" value="{{ old("dateend")??substr($info->dateend,0,10)??"" }}">
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="mb-3">
                        @error('file')
                            
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image"  @if(!$info) required @endif>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select class="form-select select2" id="tags" name="tags[]" multiple required>
                            @php
                                $selectedTags = [];
                                if(old("tags")){
                                    $selectedTags = old("tags");
                                } else if($info){
                                    $selectedTags = $info->tags->pluck("id")->toArray();
                                }
                            @endphp
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" @if(in_array($tag->id,$selectedTags)) selected @endif>{{ $tag->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
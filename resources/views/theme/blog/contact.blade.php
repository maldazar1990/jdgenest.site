@extends('theme.blog.layout.app')

@section("content")
    <div class="col-12">
        
        <div class="mb-4">
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
            <div class="flex p-1">

                <form method="post" action="{{$route}}">
                    @csrf
                    @include("toolbox.input",["inputName"=>"email","inputFieldName"=>"Email","inputType"=>"email","leurre"=>true,"model"=>null,"attributes"=>["required"=>"required","maxlength"=>"255","minlength"=>"5","autocomplete"=>"on"]])

                    @include("toolbox.input",["inputName"=>"name","inputFieldName"=>"Nom","inputType"=>"text","leurre"=>true,"model"=>null,"attributes"=>["required"=>"required","maxlength"=>"255"]])
                    @include("toolbox.input",["inputName"=>"savon","inputFieldName"=>"Votre Email","inputType"=>"email","inputClass"=>"","model"=>null,"attributes"=>["required"=>"required","maxlength"=>"255","minlength"=>"15","autocomplete"=>"on"]])
                    @include("toolbox.basictextarea",["inputName"=>"text","inputFieldName"=>"Message","model"=>null ,"attributes"=>["required"=>"required","maxlength"=>"1024","rows"=>"5","minlength"=>"10"]])

                    <button  type="submit"
                             class="btn btn-primary">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
@endsection

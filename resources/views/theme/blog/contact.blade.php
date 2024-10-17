@extends('theme.blog.layout.app')

@section("content")
    <div class="col-12">
        <script>
            function onSubmit(token) {
                document.querySelector("form").submit();
        }
        </script>
        <script src="https://www.google.com/recaptcha/api.js" defer></script>
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
                <style>
                    .emailfield{
                        display:none;
                    }
                </style>
                {!! form_start($form)!!}
                <input name="email" type="email" value="" class="emailfield">
                {!!form_row($form->name)!!}
                {!!form_row($form->savon)!!}
                {!!form_row($form->text)!!}
                    @if (config("app.env")=="local")
                        <button  type="submit"
                             class="btn btn-primary">
                        Envoyer
                        </button>
                    @else
                    <button  type="submit"
                             class="btn btn-primary g-recaptcha"
                             data-sitekey="{{config("app.recaptcha")}}"
                             data-callback='onSubmit'
                             data-action='submit'>
                        Envoyer
                    </button>
                    @endif
                {!!form_end($form)!!}
            </div>
        </div>
@endsection

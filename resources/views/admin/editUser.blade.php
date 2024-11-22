@extends('admin.layouts.app')

@section("content")
    <div class="col-12">
        <div class="card mb-4">
            @include("toolbox.error")
            <div class="card-block">

                <form id="adminForm" method="POST" action="{{ route("admin_user_update",$model) }}" enctype="multipart/form-data">
                    @csrf
                    @if ( isset($model) )
                        <h5>image actuel</h5><br>
                        @include("toolbox.image", ['modelWithImage' => $model,"class" => "img-fluid mb-4","size"=>"medium"])
                    @else
                        <img src="images/default.webp" id="previewImage" alt='image actuel' width='200px' class='img-fluid mb-3 d-none'>

                    @endif
                    @include("toolbox.input",["inputName"=>"name","inputFieldName"=>"Nom","inputType"=>"text","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"]])
                    @include("toolbox.input",["inputName"=>"email","inputFieldName"=>"Courriel","inputType"=>"email","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"]])
                    @include("toolbox.input",["inputName"=>"password","inputFieldName"=>"Mot de passe","inputType"=>"password","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"]])
                    @include("toolbox.input",["inputName"=>"jobTitle","inputFieldName"=>"Titre","inputType"=>"text","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required"]])
                    @include("toolbox.textarea",["inputName"=>"presentation","inputFieldName"=>"Présentation","model"=>$model])
                    @include("toolbox.input",["inputName"=>"image", "inputId"=>"imageUpload", "inputFieldName"=>"Image","inputType"=>"file","inputClass"=>"","model"=>$model,"attributes"=>["required"=>"required","accept"=>"image/*"]])
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    @if(env("APP_ENV")!="Production")


        @if (auth()->user()->two_factor_secret )
            @if (session('status') != 'two-factor-authentication-enabled' and !session("error_code") and auth()->user()->two_factor_confirmed_at != 0 )
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-block">
                            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                @csrf
                                <h3 class="card-title">2 facteurs</h3>

                                @method('DELETE')
                                <button class="btn btn-danger">Désactivé</button>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-block">
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            <h3 class="card-title">2 facteurs</h3>
                            L'authentification à deux facteurs n'est pas activée.
                            <button class="btn btn-primary">Activé</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if ((session('status') == 'two-factor-authentication-enabled' or session("error_code")) or (auth()->user()->two_factor_confirmed_at==0and auth()->user()->two_factor_secret != ""))
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-block">
                        <h3 class="card-title">Activé code qr</h3>
                        <div class="mb-4 font-medium text-sm">
                            L'authentification à deux facteurs est activée.
                        </div>

                        <h3>Code QR pour les applications d'authentification</h3>
                        <div class="pt-5 pb-5">
                            {!!  auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>
                        <div class="mt-4 font-medium text-sm">
                            @foreach (auth()->user()->recoveryCodes() as $code)
                                {{ $code }}<br>
                            @endforeach
                        </div>
                        <form method="POST" action="{{route("twofactorconfirm")}}">
                            @csrf

                            <div class="form-group mt-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code">
                            </div>
                            <button class="btn btn-primary">Confirmer</button>
                        </form>
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Désactivé</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection



`

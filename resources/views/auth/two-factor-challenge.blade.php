@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Défi à deux facteurs') }}</div>

                    <div class="card-body">
                        {{ __('Veuillez entrer votre code d\'authentification pour vous connecter.') }}

                        <form method="POST" action="{{ route('two-factor.login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('Code') }}</label>

                                <div class="col-md-6">
                                    <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" required >

                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirmer le code') }}
                                    </button>
                                    <a href="{{route("recupForm")}}">Code de récupération</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
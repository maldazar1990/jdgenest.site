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
                {!! form($form) !!}
            </div>
        </div>
    </div>
    @if($form instanceof App\Http\Forms\UserForm )
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-block">
                    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                        @csrf
                        <h3 class="card-title">2 facteurs</h3>
                        @if(auth()->user()->two_factor_secret)
                            @method('DELETE')
                            <button class="btn btn-danger">Disable</button>
                        @else
                            Two factor authentication is not enabled.
                            <button class="btn btn-primary">Enable</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @if (session('status') == 'two-factor-authentication-enabled')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-block">
                        <h3 class="card-title">Activé code qr</h3>
                        <div class="mb-4 font-medium text-sm">
                            Two factor authentication is enabled.
                        </div>
                        
                        <h3>QR Code for authenticator applications</h3>
                        <div class="pt-5 pb-5">
                            {!!  auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>
                        <form method="POST" action="{{url("/user/confirmed-two-factor-authentication")}}">
                            @csrf
                            
                            <div class="form-group mt-3">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code">
                            </div>
                            <button class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if (session('status') == 'two-factor-authentication-confirmed')
            @dump(session())
             <div class="col-12">
                <div class="card mb-4">
                    <div class="card-block">
                        
                        <div class="mb-4 font-medium text-sm">
                            Two factor authentication confirmed and enabled successfully.
                        </div>
                        <div class="mb-4 font-medium text-sm">
                            $request->user()->recoveryCodes()
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection



`
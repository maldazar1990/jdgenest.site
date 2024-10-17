@extends('admin.layouts.app')

@section("content")

    <div class="col-12">
        <div class=" mb-4">
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
            @php
            $actualRoute = Route::currentRouteName();
            $deleteRoute = "";
            switch($actualRoute){
                case "admin_msg":
                    $deleteRoute = "admin_msg_delete_all";
                    break;
                case "admin_comment":
                    $deleteRoute = "admin_comment_delete_all";
                    break;
                default:
            }
            @endphp
            @if(!isset($liveWireTable))
            <div class="card-block grid_view">
                <h3 class="card-title">{{$title}}</h3>
                {!! @grid_view($gridviews) !!}
                @if($deleteRoute != "")
                <form method="post" class="mt-1" action="{{route($deleteRoute)}}" >
                    @csrf
                    <button type="submit" class="btn btn-danger">Tous supprimer</button>
                </form>
                @endif
            </div>
            @else
            @livewire($liveWireTable)
            @endif

        </div>
    </div>
@endsection

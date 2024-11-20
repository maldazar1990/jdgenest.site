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


            <div class="card-block table-responsive" style="overflow: scroll">
                <h3 class="card-title">{{$title}}</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Http\Helpers­\Image::getImages() as $key=>$image)
                            <tr class="border h-25" >
                                <td>{{$key}}</td>
                                <td>
                                    <img style="max-height: 100px" src="{{asset('images/'.$image)}}" alt="{{$key}}" class="img-fluid">
                                </td>
                                <td class="border">
                                    @if(!\App\Http\Helpers\Image::isImageUsed($key))
                                        <a class="btn btn-danger link-light" href="{{route('admin_files_delete')}}?image={{$key}}">Supprimer</a>
                                    @else
                                        Ne peut pas être supprimé
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

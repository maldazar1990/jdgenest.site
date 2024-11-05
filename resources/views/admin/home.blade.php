@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table>
                        <thead>
                            <tr>
                                <th>sujet</th>
                                <th>statistiques</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre de posts</td>
                                <td>
                                    <a href="{{route("admin_posts")}}">
                                       {{\App\post::count()}}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre d'images</td>
                                <td>
                                    <a href="{{route("admin_files")}}">
                                        {{count(\App\Http\Helpers\Image::getImages())}}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre de messages</td>
                                <td>
                                    <a href="{{route("admin_msg")}}">
                                        {{\App\Contact::count()}}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre d'ip ban</td>
                                <td>
                                        {{\Illuminate\Support\Facades\DB::table("firewall_ips")->select('ip')->distinct()->get()->count()}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

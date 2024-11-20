@extends('theme.blog.layout.app')

@section("content")

    @include("theme.blog.layout.search")
    <div class="container">
        @forelse($posts as $post)
            @include("theme.blog.layout.post")
        @empty
            <div class="alert alert-warning">
                <h3 class="text-center">Aucun article trouvé</h3>
            </div>
        @endforelse
    </div>
    @if(Request::has("search"))
        {{$posts->appends(["search"=>Request::get("search")])->links("vendor.pagination.bootstrap-5")}}
    @else
        {{$posts->links("vendor.pagination.bootstrap-5")}}
    @endif
@endsection

@php
 $action = route("archive");

 if( Route::getCurrentRoute()->getName() == "archiveByTag"){
     $action = route("archiveByTag",$tagId);
 }
@endphp
<form action="{{$action}}" method="get" class="mb-2 row">
    <div class="input-group">
        <input type="text" class="form-control" required minlength="3" maxlength="20" placeholder="Rechercher" name="search"
        @if(Request::has("search"))
            value="{{Request::get("search")}}"
        @endif
        >

        <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
<div class="mb-5 w-100 d-flex flex-wrap overflow-hidden">
    @php
        $search = (Request::has("search")) ? "?search=".Request::get("search") : null;
    @endphp
    @foreach($tags as $tag)
        @if( $tag->id == $tagId)
            <span class="badge bg-secondary m-1">{{$tag->title}}</span>
        @else
            <a class="badge badge-pill bg-primary disable-link m-1" href="{{route("archiveByTag",$tag).$search}}">{{$tag->title}}</a>
        @endif
    @endforeach

    @if(Request::has("search") or \Illuminate\Support\Str::contains(url()->current(),'archive'))
        <a class="badge badge-pill bg-danger disable-link m-1" href="{{route("default")}}">Réinialiser la recherche</a>
    @endif
</div>


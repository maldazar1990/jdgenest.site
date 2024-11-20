<div class="flex-wrap overflow-hidden">
    @php
        $tagId = (isset($tagId)) ? $tagId : null;
        if(Request::is('about')){
            $tags = null;
            foreach($userInfo->infos()->get() as $info){
                foreach($info->tags()->groupBy("tags.id")->get() as $tag){
                    $tags[$tag->id] = $tag;
                }
            }
        } else {
            
            $tags =Cache::remember( "tags_post_".$post->id,60*60*24, function () use ($post) {
                return $post->tags()->groupBy("tags.id")->get();
            });
        }

    @endphp
    @foreach($tags as $tag)
        @if( $tag->id == $tagId)
            <span data-class="{{\Illuminate\Support\Str::slug($tag->title)}}" data-listclass="{{\Illuminate\Support\Str::slug($tag->title)}}" class="badge bg-secondary me-1 order  pointer-event">{{$tag->title}}</span>
        @else
            @php
                $href = 'href='.route("archiveByTag",$tag);
                if(Request::is('about')){
                    $href = '';
                }
            @endphp
            <a data-class="{{\Illuminate\Support\Str::slug($tag->title)}}" data-listclass="{{\Illuminate\Support\Str::slug($tag->title)}}" class="badge badge-pill bg-primary disable-link  me-1 order  pointer-event" {{$href}}>{{$tag->title}}</a>
        @endif
    @endforeach
    @if(Request::is('about'))
        <span class="clean-tag badge badge-pill bg-danger disable-link  me-1 d-none pointer-event">Nettoyer</span>
    @endif
</div>

<div class="item mb-5">
    <div class="row g-3 g-xl-0 post-box">
        <div class="align-items-center col-xm-12 col-sm-5 col-md-5 col-lg-5 col-xl-4 d-flex">
            @include("theme.blog.layout.image", ['image' => $post->image,"class" => "img-fluid","size"=>"small"])
        </div>
        <div class="col-lg-7 col-xl-8 col-md-7 col-sm-7 col-xm-12 ps-xl-2 pt-xl-2 pb-xl-2">
            <h3 class="title mb-1"><a class="text-link" href="{{route("post",$post->slug)}}">{{$post->title}}</a></h3>
            @include("theme.blog.layout.infopost", ['post' => $post])
            <div class="mb-1">
                @include("theme.blog.layout.tags")
            </div>
            @php
                $smartpost = strip_tags($post->post);
                $smartpost = str_replace('&nbsp;', ' ', $smartpost);
                $smartpost =  Str::words($smartpost, 30, '....');

            @endphp
            <div class="intro">{{$smartpost}}</div>
            <a class="text-link" href="{{route("post",$post)}}">Pour continuer &rarr;</a>
        </div><!--//col-->
    </div><!--//row-->
</div>

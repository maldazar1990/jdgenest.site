<div class="col-12 col-md-6 col-lg-6 mb-5 ">
    <div class="card rounded-0 border-0 shadow-sm eq-height shadow-animation" >
        <div class="position-relative">
            @include("toolbox.image", ['modelWithImage' => $post,"class" => "img-fluid"])
        </div>
        <div class="card-body pb-4">
            
            <h3 class="card-title mb-4"><a class="text-link" href="{{route("post",$post->slug)}}">{{$post->title}}</a></h3>
            <div class="mb-4">
                @include("theme.blog.layout.tags")
            </div>
            <div class="card-text">
                {{\App\Http\Helpers\HelperGeneral::getFirstWordFromText($post->post,30)}}
            </div>

        </div>
        <div class="card-footer">
            @include("theme.blog.layout.infopost", ['post' => $post])
        </div>
    </div>
</div>
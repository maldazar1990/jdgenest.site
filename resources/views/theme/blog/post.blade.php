@extends('theme.blog.layout.app')

@section("content")
    <script>
        function onSubmit(token) {
            document.querySelector("form").submit();
        }
    </script>
    <div class="d-none d-sm-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("default")}}">Page principale</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
            </ol>

        </nav>
    </div>
    <article class="blog-post">
        <div class="container single-col-max-width ps-0 pe-0">
            <header class="blog-post-header">
                <h2 class="title mb-2">{{$post->title}}</h2>
                @include("theme.blog.layout.infopost", ['post' => $post])
                <div class="d-flex col w-100 mb-2">
                    <div class="w-100">
                        @include("theme.blog.layout.tags")
                    </div>
                </div>
            </header>

            <div class="blog-post-body">

                @if ($post->image)
                    <div class="mb-4">
                        @include("theme.blog.layout.image", ['image' => $post->image])
                    </div>
                @endif
                <div class="textcontent">
                    {!! trim($post->post) !!}
                </div>
                <div class="mt-5 mb-5">
                    <h3>Section commentaires</h3>
                    <div class="row  d-flex justify-content-center">
                        @forelse( $comments as $comment )

                            <div class="m-3 mt-2">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="user d-flex flex-row align-items-center">
                                        <span><small class="font-weight-bold">{{$comment->post}}</small></span>

                                    </div>

                                    @if($comment->created_at)
                                        <small>{{$comment->created_at->format("Y-m-d")}}</small>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div>
                                Pas de commentaire
                            </div>
                        @endforelse
                    </div>
                    <form method="post" action="{{route("send_comment",$post->id)}}">
                        @csrf
                        @if($errors)
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                            </ul>
                        @endif
                        <style>
                            .emailfield{
                                display:none;
                            }
                        </style>
                        <h4><label for="patate" style="control-label">Ton commentaire:</label></h4>
                        <textarea id="patate" name="patate" class="form-control input-lg mb-2" placeholder="Commentaire" minlength="10" maxlength="255" required autocomplete="off">

                        </textarea>
                        <input name="email" type="email" value="" class="emailfield">
                        @if(config("app.env")=="production")
                        <button  type="submit"
                            class="btn btn-primary ">
                            Envoyer
                        </button>
                        @else
                            <button  type="submit"
                                     class="btn btn-primary">
                                Envoyer
                            </button>
                        @endif
                    </form>
                </div>
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v15.0&appId=423139100007993&autoLogAppEvents=1" nonce="Whz0B25a"></script>
                <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fjdgenest.site%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Partager</a></div>
                <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: fr_CA</script>
                <script type="IN/Share" data-url="{{url()->current()}}"></script>
            </div>
        </div>
    </article>
@endsection

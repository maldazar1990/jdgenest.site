@extends('theme.blog.layout.app')

@section("content")
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

                    <div class="mb-4 d-flex flex-column align-items-center">

                        @include("toolbox.image", ['modelWithImage' => $post])
                    </div>
                <div class="textcontent">
                    {!! trim($post->post) !!}
                </div>
		<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: fr_CA</script>
                <script type="IN/Share" data-url="{{url()->current()}}"></script>
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
                        @if(isset($message))
                            <div class="alert alert-success">
                                {{$message}}
                            </div>
                        @endif
                        <style>
                            .emailfield{
                                display:none;
                            }
                        </style>
                        <h4><label for="patate" style="control-label" id="comment">Ton commentaire:</label></h4>



                        <div class="input-group " style="height:100px">
                            <textarea class="form-control custom-control h-100" rows="3"  id="patate" name="patate"  style="resize:none" placeholder="Commentaire" minlength="10" maxlength="1024" required autocomplete="off"></textarea>
                            <button  type="submit"
                                class="input-group-addon btn btn-primary h-100">
                                Envoyer
                            </button>
                        </div>

                        <input name="email" type="email" value="" class="emailfield">
                        

                    </form>
                </div>
                @if($otherPosts->count() > 0)
                <h3 class="mt-3 mb-3">Autres articles dans les mêmes sujets</h3>
                <div class="row">
                    
                @foreach($otherPosts as $otherPost)
                     @include("theme.blog.layout.post",['post'=>$otherPost])
                @endforeach
                </div>
                @endif
                <?php
                      /*
                <comment-element id="{{$post->id}}" commentList="{{$comments->toJson()}}">
                    <p slot="comment">test</p>
                </comment-element>*/?>
           
            </div>
        </div>
    </article>
@endsection

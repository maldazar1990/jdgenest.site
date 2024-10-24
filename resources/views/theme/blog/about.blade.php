@extends('theme.blog.layout.app')

@section("content")
    <div class="d-flex flex-column align-items-center justify-center">

        <article class="about-section py-sm-2 py-md-3 py-lg-5">
            <div class="container pe-0 ps-0">
                {{-- <h2 class="title mb-3 text-center">En résumé</h2>
                <div class="container mt-5 mb-5 ps-0 pe-0 text-left">
                    {!!$userInfo->presentation!!}
                </div>--}}
                <h4>Compétences</h4>
                @include("theme.blog.layout.tags")
                <div class="container mt-5 mb-5 ps-0 pe-0 justify-content-start align-items-start align-content-start">
                    <div class="row">
                        <div class="">
                            <h4>Études et expériences</h4>
                            <ul class="timeline">
                   
                                @foreach( $infos as $info)
                                    @php
                                    $tagClass = "";
                                    $tags = Cache::rememberForever("tags_info_".$info->id, function () use ($info) {
                                        return $info->tags()->get();
                                    });

                                    foreach ($tags as $tag){
                                        $tagClass .= " ".\Illuminate\Support\Str::slug($tag->title);
                                    }
                                    @endphp
                                    <li class="d-flex flex-column about-me-general" data-listclass="{{$tagClass}}">
                                        <a target="_blank" class="link-secondary mb-1 " href="{{$info->link}}">
                                            <h5>{{$info->title}}</h5>
                                        </a>
                                        <div class="d-flex justify-content-start align-content-start">
                                            @include("theme.blog.layout.image", ['image' => $info->image,"class" => "mb-2 img-info", "css"=>"width: 200px;height: 100%;object-fit: contain;"])
                                        </div>
                                        <small>
                                            @if($info->dateend < \Illuminate\Support\Facades\Date::today())
                                                <span class="float-right w-100 mb-1">{{$info->datestart}}  à {{$info->dateend}}</span>
                                            @else
                                                <span class="float-right w-100 mb-1">Depuis {{$info->datestart}}</span>
                                            @endif
                                        </small>
                                        <div>
                                            @foreach( $info->tags()->groupBy("tags.id")->get() as $tag)
                                                <span class="badge badge-pill bg-secondary disable-link">{{$tag->title}}</span>
                                            @endforeach
                                        </div>
                                        <a data-bs-toggle="collapse"
                                           class="nav-link collapsed"
                                           href="#{{\Illuminate\Support\Str::slug($info->title,"_")}}"
                                           role="button">
                                            <small class="more-text">Pour plus de détails cliquez ici.<span class="active" >▲</span></small>
                                        </a>
                                        <div class="panel-collapse collapse in" aria-expanded="false"  id="{{\Illuminate\Support\Str::slug($info->title,"_")}}">
                                            <p>{!!trim($info->description)!!}</p>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container mt-5 mb-5 ps-0 pe-0 justify-content-start align-items-start align-content-start">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3">Projets</h4>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach($userInfo->infos()->where("type","exp")->get() as $info)
                                    @php
                                        if (!\Illuminate\Support\Str::contains($info->image, 'http') and !empty($info->image)) {
                                            $image =  asset('images/' . $info->image);
                                        }else if (Str::contains($info->image, 'http')) {
                                            $image =  $info->image;
                                        } else {
                                            $image =  asset('images/default.jpg');
                                        }

                                        $tagClass = "";
                                        foreach ($info->tags()->get() as $tag){
                                            $tagClass .= " ".\Illuminate\Support\Str::slug($tag->title);
                                        }
                                        $smartpost = strip_tags($info->description);
                                        $smartpost = str_replace('&nbsp;', ' ', $smartpost);
                                        $smartpost =  Str::words($smartpost, 10, '....');
                                    @endphp

                                    <div class="col" data-listclass="{{$tagClass}}">
                                        <div class="card">
                                            <div class="p-2">
                                                @include("theme.blog.layout.image", ['image' => $info->image,"class" => "card-img-top"])
                                            </div>
                                            <span class="ms-3">
                                                @foreach( $info->tags()->groupBy("tags.id")->get() as $tag)
                                                    <span class="badge badge-pill bg-secondary disable-link">{{$tag->title}}</span>
                                                @endforeach
                                            </span>
                                            <div class="card-body">
                                                <h5 class="card-title">{{$info->title}}</h5>

                                                <p class="card-text">{{$smartpost}}</p>
                                                <small>
                                                    @if($info->dateend < \Illuminate\Support\Facades\Date::today())
                                                        <span class="float-right w-100 mb-1">{{$info->datestart}}  à {{$info->dateend}}</span>
                                                    @else
                                                        <span class="float-right w-100 mb-1">Depuis {{$info->datestart}}</span>
                                                    @endif
                                                </small>
                                                <br>
                                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#{{\Illuminate\Support\Str::slug($info->title)}}">
                                                    Détails
                                                </button>
                                            </div>
                                        </div>

                                        <!--modal-->
                                        <div class="modal fade" id="{{\Illuminate\Support\Str::slug($info->title)}}" tabindex="-1" aria-labelledby="{{\Illuminate\Support\Str::slug($info->title)}}label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="{{\Illuminate\Support\Str::slug($info->title)}}label">{{$info->title}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $info->description !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <a href="{{$info->link}}" target="_blank" class="btn btn-primary center-btn">Aller sur le site</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </article><!--//about-section-->


    </div><!--//main-wrapper-->

@endsection

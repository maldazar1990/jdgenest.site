<div class="main-wrapper min-vh-100 d-flex flex-column ">

    @if(Route::currentRouteName() != "post")
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center single-col-max-width">
            @if(Request::is("about"))
                <h2 class="heading">{{(isset($title))?$title:""}}</h2>
                <div class="title-intro">{!!(isset($message))?$message:""!!}</div>
                <a class="btn btn-primary center-btn" href="{{route("contact")}}">Pour me contacter</a>
            @else
                <h2 class="heading">{{(isset($title))?$title:""}}</h2>
                <div class="title-intro" id="title">
                    {{(isset($message))?$message:""}}
                </div>
            @endif
            </div><!--//container-->
        </section>
    @endif
        <section class="blog-list d-flex flex-column">
            <div class="container single-col-max-width pt-3 pb-3">
                @yield('content')
            </div>
        </section>
    @include("theme.blog.layout.footer")
</div><!--//main-wrapper-->


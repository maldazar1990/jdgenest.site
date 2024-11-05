<header class="header text-center  d-flex flex-column justify-content-md-start justify-content-center">
    @php

    if(!isset($options)){
        $options = \App\options_table::all()->pluck("option_value","option_name")->toArray();
    }

    if(!isset($userInfo)){
        $userInfo = \App\Users::find(1);
    }
    @endphp
    <h1 id="titlewebsite" class="blog-name pt-lg-4 mb-0"><a class="no-text-decoration header-text" style="z-index:1" href="{{route("default")}}">{{$options['nom']}}</a></h1>

    <nav class="navbar navbar-expand-lg navbar-dark" >

        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>
        </button>
        
        <div id="navigation" class="collapse navbar-collapse flex-column" >
            <div class="profile-section pt-3 pt-lg-0">
                @include("theme.blog.layout.image", ['image' => $userInfo->image,"class" => "profile-image mb-3 rounded-circle mx-auto img-cover","size"=>"small"])

                <div class="bio mb-3">{{$options["simple_presentation"]}}</div><!--//bio-->
                <ul class="social-list list-inline py-3 mx-auto">
                    <li class="list-inline-item"><a href="{{$options["linkedin"]}}"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="{{$options['gitlab']}}"><i class="fab fa-github-alt fa-fw"></i></a></li>
                    <li class="list-inline-item"><a rel="alternate" type="application/atom+xml" title="News" href="/feed"><i class="fa fa-rss"></i></a></li>

                </ul><!--//social-list-->
                <hr>
            </div><!--//profile-section-->

            @include("theme.blog.layout.nav")
        </div>
    </nav>
    <script>
        let head = document.querySelector(".header");
        let title = document.querySelector("#titlewebsite");
        let collnav = document.getElementById("navigation");
        collnav.addEventListener("hidden.bs.collapse",function(){
            console.log(1);
            head.classList.add("justify-content-center");
                title.style.top = "";
        });
         collnav.addEventListener("show.bs.collapse",function(){
            

                head.classList.remove("justify-content-center");
            title.style.top = '10px';
        });
    </script>
</header>

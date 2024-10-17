<ul class="navbar-nav flex-column text-start">
    <li class="nav-item">
        <a class="nav-link {{(Route::currentRouteName()=="default")?"active":""}}" href="{{route("default")}}"><i class="fas fa-home fa-fw me-2"></i>Blogue</a>
    </li>
    {{--<li class="nav-item">
        <a class="nav-link {{(str_contains(url()->current(),"archive"))?"active":""}}" href="{{route("archive")}}"><i class="fas fa-bookmark fa-fw me-2"></i>Blogue</a>
    </li>--}}
    <li class="nav-item">
        <a class="nav-link {{(str_contains(url()->current(),"about"))?"active":""}}" href="{{route("about")}}"><i class="fas fa-user fa-fw me-2"></i>À mon sujet</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{(str_contains(url()->current(),"contact"))?"active":""}}" href="{{route("contact")}}"><i class="fas fa-address-book fa-fw me-2"></i>Contact</a>
    </li>
</ul>

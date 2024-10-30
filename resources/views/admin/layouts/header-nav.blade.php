<header class="page-header row justify-center">
    @php
        if (Auth::user()->image)
            $image = asset("images/".Auth::user()->image);
        else
            $image = asset("images/default.png");
    @endphp
    <div class="dropdown user-dropdown col-md-12 col-lg-12 text-right text-md-right"><a class="btn btn-stripped dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{$image}}" alt="profile photo" class="circle float-left profile-photo" width="50" height="auto">
            <div class="username mt-1">
                <h4 class="mb-1">{{Auth::user()->name}}</h4>

                @foreach(Auth::user()->roles()->get() as $role)

                    <h6 class="mb-1">{{$role->name}}</h6>
                @endforeach
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="margin-right: 1.5rem;" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{route("admin_user")}}"><em class="fa fa-user-circle mr-1"></em> Profile</a>
            <a class="dropdown-item" href="{{route("default")}}"><em class="fa fa-link mr-1"></em> Site Web</a>
            <a class="dropdown-item" href="{{route("two-factor.login")}}"><em class="fa fa-key mr-1"></em> 2fa</a>
            <a class="dropdown-item" href="{{route("get-logout")}}"><em class="fa fa-power-off mr-1"></em> déconnection</a>
        </div>
    </div>
    <div class="clear"></div>
</header>

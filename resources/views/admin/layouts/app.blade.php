<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

    window.appurl = "{!! config("app.url") !!}";
</script>
@include("admin.layouts.header")
<body>

<div class="container-fluid" id="wrapper">
    <div class="row">
        @if( Auth::check() )
            @include("admin.layouts.navbar")
        @else
            <style>
                main-wrapper{
                    height: 100vh;
                }
            </style>
        @endif

        <main class="
            @if(auth::check())
                pt-3 pl-4 ml-auto col-xs-12 col-sm-8 col-lg-9 col-xl-10
            @else
                d-flex w-100 h-100 p-3 mx-auto flex-column main-wrapper
            @endif
            ">
            @if( Auth::check() )
                @include("admin.layouts.header-nav")
            @endif
            <section class="row">
                <div class="col-sm-12">
                    <section class="row">
                        @yield("content")
                    </section>
                </div>
            </section>
        </main>
    </div>
</div>
@laravelViewsScripts(laravel-views,livewire,alpine)
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</html>

<head lang="{{config("app.locale")}}">
    @php
    $titleWebsite = config("app.name");

    if (isset($title)) {
        $titleWebsite = $titleWebsite." - ".$title;
    }
    @endphp

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msvalidate.01" content="F1D5E61C37FD05432D25AD5F41950533" />
    <link rel="shortcut icon" href="{{asset("favicon.ico")}}">
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://www.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @if(isset($SEOData))
        {!! seo($SEOData) !!}
    @endif
    <link id="theme-style" rel="stylesheet" href="{{mix("front/css/app.css")}}?v={{microtime()}}">
    <link rel="preload"  load href="{{mix("front/js/app.js")}}" as="script"/>
    <script src="{{mix("front/js/app.js")}}" defer></script>
</head>

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
    <meta name="theme-color" content="#0A71C6">
    <link rel="shortcut icon" href="{{asset("favicon.ico")}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($SEOData))
        {!! seo($SEOData) !!}
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>

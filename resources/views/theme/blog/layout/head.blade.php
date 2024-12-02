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
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <script type="text/javascript"> (function() {
        var css = document.createElement('link');
        css.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css';
        css.rel = 'stylesheet';
        css.type = 'text/css';
        css.crossorigin="anonymous";
        css.referrerpolicy="no-referrer";
        css.async = true;
        document.getElementsByTagName('head')[0].appendChild(css); })();
    </script>
    <script type="text/javascript">
        (function() {
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js';
            script.async = true;
            document.getElementsByTagName('head')[0].appendChild(script);
        })();
    </script>
</head>

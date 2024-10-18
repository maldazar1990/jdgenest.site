<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{asset('admin/js/app.min.js') }}" defer></script>
    <link href="{{asset("admin/css/app.min.css")}}" rel="stylesheet">
    
    @laravelViewsStyles(laravel-views,tailwindcss,livewire)

</head>

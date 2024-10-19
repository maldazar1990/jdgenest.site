<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @if(config("app.env") == 'production')
        <script src="{{asset('admin/js/app.js') }}" defer></script>
    @else
        <script src="{{asset('admin/js/app.js?v='.microtime()) }}" defer></script>
    @endif
    <link href="{{asset('admin/css/app.css')}}" rel="stylesheet">
    @laravelViewsStyles(laravel-views,tailwindcss,livewire)
    
</head>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Dummy Company">
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" media="all" rel="stylesheet" type="text/css">
    <!-- Fontawesome for (temp) icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    @yield('head_extra')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148190403-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-148190403-1');
    </script>


</head>
<body style="margin: 0 !important;">
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    @yield('script_extra')
</body>
    @include('partials.sentry-javascript-error-initialisation')
    @include('partials.company-search-state')
    <script type="text/javascript">
        @stack('scripts')
    </script>
    <script src="{{ mix('/js/app.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        {!!  show_flash_message()  !!}
        $(document).ready(function () {
            @stack('scripts-ready')
        });
    </script>
</html>

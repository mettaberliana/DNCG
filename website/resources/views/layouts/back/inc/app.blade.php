<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('assets/Banner/griologo.ico') }}" />
    <title>Cashier Grio Coffee</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    <livewire:styles />
    <livewire:scripts />

</head>

<body>
    <div id="app" style="min-height: 54.3rem; " class="app">
        @include('layouts.back.inc.header')
        <main class="py-4">

            @yield('content')


        </main>


    </div>
</body>
@include('layouts.footer')

</html>
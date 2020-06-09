<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{config('app.name')}}</title>


    <title>{{config('app.name')}}</title>

    <meta name="description"
          content="Bezorgfiets is de leverancier voor E-bikes die gebruikt worden bezorgbedrijven">
    <meta name="author" content="Rmnd Design">
    <meta name="robots" content="noindex, nofollow">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">

    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="{{ mix('css/themes/xbr.css') }}">
@yield('css_after')

<!-- Scripts -->
    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
</head>
<body>

<div id="page-container"
     class="main-content-narrow">

    <main id="main-container">
        @yield('content')
    </main>
</div>
<!-- END Page Container -->

<!-- Dashmix Core JS -->
<script src="{{ mix('js/dashmix.app.js') }}"></script>

<!-- Laravel Scaffolding JS -->
<!-- <script src="{{ mix('/js/laravel.app.js') }}"></script> -->

@yield('js_after')
</body>
</html>


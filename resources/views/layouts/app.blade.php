<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/vue.js') }}" defer></script>
    <script src="{{ asset('js/vue-components.js') }}" defer></script>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,900" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.php') }}" rel="stylesheet">
</head>
<body>
@yield('content')
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@AdamBot</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    @if(!Auth::check())
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @endif
</head>
<body>
<audio id="audio">
    <source src="{{ asset('mp3/Sound.mp3') }}"></source>
</audio>

@yield('content')

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

@if(Auth::check())
    <script src="{{ asset('js/chat.js') }}"></script>

    <script src="{{ asset('js/bot.js') }}"></script>

    <script src="{{ asset('js/help.js') }}"></script>

    <script src="{{ asset('js/js.cookie.js') }}"></script>
@endif

<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>

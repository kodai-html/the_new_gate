<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <header>
            @include('header')
        </header>
        <div class="container">
            @yield('content')
        </div>
        <footer class="footer bg-dark  fixed-bottom">
            @include('footer')
        </footer>
    </body>
</html>

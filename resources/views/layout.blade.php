<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/product.js') }}" defer></script>
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

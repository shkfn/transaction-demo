<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" id="@yield('id', '')">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'Home')</title>

    <!--css-->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    @stack('styles')

    <!--js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/csrf_token.js')}}"></script>
    @stack('scripts')
</head>

<body>
<div id="content">
    @yield('content')
</div>
</body>
</html>

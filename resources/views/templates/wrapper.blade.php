<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        $templateRoute = str_replace(".", "/", $template);
    ?>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('templates/' . $templateRoute . '.css') }}" rel="stylesheet">
    <title> {{ $name }} </title>
    @yield('head')
</head>

<body>
    @yield('body')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ Asset('js/jquery-ui-1.10.4.min.js') }}"></script>
    <script src="{{ Asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ Asset('templates/' . $templateRoute . '.js') }}"></script>
    @yield('foot')
</body>

</html> 

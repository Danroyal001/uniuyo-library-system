<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="shortcut icon" href="">
    <link rel="image_src" href="" />
    <link rel="canonical" href="" />

    <title>{{ getAppName(); }}</title>

    <link type="text/css" href="{{ asset('static/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('static/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- JavaScript Bundle with Popper -->

    <link type="text/css" href="{{ asset('static/css/theme.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('static/images/icons/css/font-awesome.css') }}" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>

    @include('common.script_top')

</head>

<body>

    <style>
        .wrapper {
            background: url(../images/bg.png) #eee;
            border-bottom: 1px solid #bbb;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            padding: 30px 0;
            height: 91vmin;
        }

        .module-head {
            /* background-color: #9400D3; */
            background-color: rgba(19, 35, 47, 0.9);
            color: #fff;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            text-transform: uppercase;
            font-style: bold;
        }

        .module-head h3 {
            color: #fff;
        }

        .widget-menu {
            /* background: #9400D3 !important; */
            background-color: rgba(19, 35, 47, 0.9) !important;
            color: #fff;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            text-transform: uppercase;
            font-style: bold;
        }

        .widget-menu>li>a {
            background-color: rgba(19, 35, 47, 0.9) !important;
            color: #ffffff;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }

        .navbar-inner {
            /* background: #9400D3 !important; */
            background: rgba(19, 35, 47, 0.9) !important;
            color: #fff;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            text-transform: uppercase;
            font-style: bold;
        }

        .error {
            color: red !important;
            font-weight: bold;
        }
    </style>

    @include('account.navigation_top')
    @include('account.message')
    @yield('content')
    @include('account.navigation_bottom')

    <script src="{{ asset('static/scripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/scripts/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/scripts/underscore-min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('static/custom/js/script.common.js') }}" type="text/javascript"></script>

    @include('common.script_bottom')

    <script type="text/template" id="alert_box">
    @include('underscore.alert_box')


</script>

    <script>
        $(document).ready(function() {
            $("input").attr("autocomplete", "off");
        });
    </script>

</body>

</html>

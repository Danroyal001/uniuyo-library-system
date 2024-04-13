<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Alagie Singhateh">
    <meta name="description" content="Programming with singhateh from the gambia west africa">
    <meta name="keywords" content="library management system, laravel 11, programming with singhateh">


    <title>Online Library Management System</title>

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

        .content-bg {
            gap: 14px;
            background-color: #c7d2fe;
            border-radius: 0px 0px 8px 8px;
            padding: 16px;
        }
    </style>

    @if (!Route::is('home'))
        <style>
            @import url("https://fonts.googleapis.com/css?family=Roboto:400,400i,700");

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Roboto', sans-serif;
            }

            .tab-buttons {
                display: flex;
                gap: 8px;
            }

            .tab-btn {
                width: 100%;
                border: none;
                color: #020617;
                background-color: #f0f8ff;
                border-radius: 8px 18px 0px 0px;
                font-weight: 500;
                padding: 12px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .tab-btn:hover {
                background-color: #a5b4fc;
            }

            .tab-btn.active {
                background-color: #c7d2fe;
            }

            .content {
                display: none;
            }

            .content.show {
                display: flex;
                gap: 14px;
                background-color: #c7d2fe;
                border-radius: 0px 0px 8px 8px;
                padding: 16px;
            }


            .content.show table {
                /* border: none; */
                font-size: 15px;
            }

            .module {
                width: 60vw;
            }

            .content img {
                width: 10%;
                height: 100px;
            }

            /* Styles for the custom table */
            .custom-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #e2e8f0;
                font-family: Arial, sans-serif;
            }

            /* Styles for table headers */
            table th {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 2px solid #cbd5e0;
                background-color: #f7fafc;
                font-weight: bold;
                color: #4a5568;
            }

            /* Styles for table cells */
            table td {
                padding: 10px 15px;
                text-align: left;
                border-bottom: 1px solid #cbd5e0;
                color: #4a5568;
            }

            /* Alternate row background color */
            table tbody tr:nth-child(even) {
                background-color: #edf2f7;
            }

            /* Hover effect */
            table tbody tr:hover {
                background-color: #e2e8f0;
            }

            .btn-link {
                font-size: 20px;
                color: #4a5568;
                text-decoration: none;
            }
        </style>
    @endif

    @include('layout.template_navbar')

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    @include('layout.template_leftbar')
                </div>
                <div class="col-md-9">
                    @include('account.message')
                    @yield('content')

                </div>
            </div>
        </div>
    </div>

    @include('layout.template_footer')


    <script src="{{ asset('static/scripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/scripts/jquery-ui-1.10.1.custom.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('static/scripts/underscore-min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('static/custom/js/script.common.js') }}" type="text/javascript"></script>

    @include('common.script_bottom')

    <script type="text/template" id="alert_box">
        @include('underscore.alert_box')
        <script>
            $(document).ready(function() {
                // Dismiss the alert after 10 seconds with fade effect
                setTimeout(function() {
                    $('.alert').fadeOut('slow', function() {
                        $(this).alert('close');
                    });
                }, 5000); // 5 seconds
            });
        </script>
    </script>


    <script>
        $(document).ready(function() {
            $("input").attr("autocomplete", "off");
        });

        window.isEmptyObject = function(data) {
            return typeof data === 'string';
        };
    </script>

</body>

</html>

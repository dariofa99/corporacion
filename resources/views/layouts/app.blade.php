<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lybra') }}</title>

    <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css"
        integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* Sticky footer styles
-------------------------------------------------- */
        html {
            position: relative;
            min-height: 100%;
        }

        body {
            margin-bottom: 60px;
            /* Margin bottom by footer height */
        }

        .card-header {
            position: relative;
        }

        .card {

            background-color: #ffffffc7;
            min-height: 280px;
            margin-bottom: 70px;
        }

        .btn-danger {
            color: #fff;
            background-color: #a4185e;
            border-color: #a4185e;
        }

        .text-header {
            padding-top: 25px;
            padding-bottom: 23px;
            text-align: center;
            font-size: 19px;
            font-weight: 600;
        }

        .img-header {
            width: 200px;
            margin: 10px;
        }

        .image {
            padding-left: 50px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 150px;
            /* Set the fixed height of the footer here */
            line-height: 30px;
            /* Vertically center the text there */
            background-color: #ffffff;
        }


        /* Custom page CSS
-------------------------------------------------- */
        /* Not required for template or sticky footer method. */

        .container-footer {

            width: 100%;
            max-width: 100%;
            padding: 15px 15px;
            background-color: #fffff !important;
        }

        .img-brading-footer {
            width: 70%;
            max-width: 1500px;
            margin-bottom: -80px;
        }

        @media (max-width: 800px) {



            .image {
                padding-left: 30px;
                text-align: center;

            }

            .text-header {
                padding-top: 0px;
                padding-bottom: 0px;
                font-size: 15px;
                font-weight: 600;
            }

            .img-header {
                width: 50px;
                margin: 5px;
            }



        }
    </style>

</head>

<body class="content-wrapper" style="background-color: #4e3789;">
    <br>
    <div class="row" style="background-color: #ffffff; opacity: .9; margin-right: 0px;">
        <div class="col-md-3 image">
            <a href="/">
                <img src="{{ asset('/dist/img/Logo_horizontal.png') }}" class="img-header elevation-2" alt="App Image">
            </a>
        </div>
        <div class="col-md-6 text-header">
            Urdiendo y Tejiendo Paz <br>
            Por la defensa de los derechos humanos en Nariño
        </div>
    </div>

    <div clas="row" style="text-align:center;margin:17px;">

        <p style="color:#ffffff;     font-size: 20px;">Sistema de atención de casos</p>
    </div>




    <div id="app">
      

        <main class="py-4" style="padding-top: 3px !important;">
            @yield('content')
        </main>

    </div>




    <footer class="footer">

        <div class="container container-footer" style="text-align:center;padding-bottom: 0px !important;">
            <img src="{{ asset('dist/img/recurso-26.png') }}" class="d-none d-sm-inline-block"
                style="width: 400px; margin-top:-144px;z-index: -1;position: absolute;margin-left: -200px;"
                alt="User Image">

            <div class="row" style="text-align: center; margin: 0px 30px 0px 30px;">
                <div class="col-md-4">
                    <span class="text-muted">Lunes a Viernes - 8:00 AM a 12:00 PM - 2:00 PM a 6:00 PM </span>
                </div>
                <div class="col-md-4">
                    <span class="text-muted">recepciondecasos@corporacionochodemarzo.org</span>
                </div>
                <div class="col-md-4">
                    <span class="text-muted">Celular: 315 6398 961</span>
                </div>
            </div>
            <img src="{{ asset('dist/img/cintilla_logos.png') }}" class="img-brading-footer" alt="User Image">
        </div>
    </footer>





</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"
    integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous">
</script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script type="text/javascript">
    var token = localStorage.getItem('tokensessionpc');
    $(document).ready(function() {

        $('.onlynumber').keyup(function() {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

        $('.onlynumber').tooltip({
            placement: "top",
            trigger: "focus"
        });
        $(".onlynumber").focus();



        $("#myLoginForm").on('submit', function(e) {
            if (typeof(Storage) !== 'undefined') {
                // Código cuando Storage es compatible
                var token = localStorage.getItem('tokensessionpc');
                //token = token;
                $(this).append($('<input>', {
                    'type': 'hidden',
                    'value': token,
                    'name': 'token'
                }));
            } else {
                // Código cuando Storage NO es compatible
            }
            // e.preventDefault();
        })
    });
</script>

</html>

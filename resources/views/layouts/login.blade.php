<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config("app.name")}} - Login</title>
    
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @import url(http://fonts.googleapis.com/css?family=Gudea:400,700);
        body {
            font-family: 'Gudea', sans-serif;
            background: url({{asset('css/login-bg.jpg')}}) no-repeat top center;
            background-size: cover;
            padding-top: 100px;
        }
        .login {
            width: 100%;
            min-height: 350px;
            padding: 100px 40px 40px 40px;
            position: relative;
            background: #35394a;
            /* Old browsers */
            background: -moz-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left bottom, right top, color-stop(0%, #35394a), color-stop(100%, #1f222e));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* IE10+ */
            background: linear-gradient(45deg, #35394a 0%, #1f222e 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#35394a', endColorstr='#1f222e', GradientType=1);
            /* IE6-9 fallback on horizontal gradient */
        }
        .login-title {
            color: #afb1be;
            height: 60px;
            text-align: center;
            font-size: 16px;
        }
        .login-fields {
            background-color: #32364a;
            width:100%;
            position:absolute;
            left:0;
        }
        .login-fields .icon {
            position: absolute;
            z-index: 1;
            right: 5px;
            top: 8px;
            color: gray;
           
        }
        input[type='password'] {
            color: #DC6180 !important;
        }
        input[type='text'],
        input[type='password'] {
            color: #afb1be;
            width: 100%;
            margin-top: -2px;
            background: #32364a !important;
            left: 0;
            padding: 10px 65px;
            border-top: 2px solid #393d52;
            border-bottom: 2px solid #393d52;
            border-right: none;
            border-left: none;
            outline: none;
            font-family: 'Gudea', sans-serif;
            box-shadow: none;
        }
        .login-submit {
            position: relative;
            top: 100px;
            left: 0;
            width: 100%;
            margin: auto;
            text-align:center;
        }
        .login-submit button {
            border-radius: 50px;
            background: transparent;
            padding: 10px 50px;
            border: 2px solid #DC6180 ;
            color: #DC6180 ;
            text-transform: uppercase;
            font-size: 11px;
            transition-property: background,color;
            transition-duration: .2s;
        }
        .login-submit button:focus {
            box-shadow: none;
            outline: none;
        }
        .login-submit button:hover {
            color: white;
            background: #DC6180 ;
            cursor: pointer;
            transition-property: background,color;
            transition-duration: .2s;
        }

    </style>
</head>
<body>
    <div id="login" >
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
   
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

        });
    </script>

</body>

</html>
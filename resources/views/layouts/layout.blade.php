
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config("app.name")}}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/sidebar.css') }}" />
    <link rel="stylesheet" href="{{asset('css/app.css') }}" />

     <script>
        window.Laravel = {!! json_encode([
            'csrfToken'     => csrf_token(),
            'imagePath'     => asset('img/villa'),
            'baseUrl'       =>  url('/')
        ]) !!};
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <div id="wrapper">
       @include('layouts.nav')
        <div>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- /#wrapper -->
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script> -->
    @yield('scripts')
</body>

</html>

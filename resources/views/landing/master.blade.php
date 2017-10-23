 <!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" type="text/css" href="{{asset('/assets/img/icons/icon.ico')}}" type="image/x-icon">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->

    <link href="{{ asset('landing/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom fonts for this template -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/vendor/font-awesome/css/font-awesome.min.css') }}" >


    <!-- Plugin CSS -->
    <link href="{{ asset('landing/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,50">

    <!-- Custom styles for this template -->
    <link href="{{ asset('landing/css/Footer-with-button-logo.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/css/full-slider.css') }}" rel="stylesheet">

    <link href="{{ asset('landing/css/creative.css') }}" rel="stylesheet">

    <link href="{{ asset('landing/css/font-awesome.css') }}" rel="stylesheet" type="text/css"`>
    <link href="{{ asset('landing/css/animate.css') }}" rel="stylesheet" type="text/css">

    @yield('additional_css')
  </head>
<body id = "page-top">
    @include('landing.navigation')  
    @yield('content')

    <script src="{{asset('landing/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('landing/vendor/popper/popper.min.js')}}"></script>
    <script src="{{asset('landing/vendor/bootstrap/js/bootstrap.min.js')}}"></script>


    <!-- Plugin JavaScript -->
    <script src="{{asset('landing/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('landing/vendor/scrollreveal/scrollreveal.min.js')}}"></script>
    <script src="{{asset('landing/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{asset('landing/js/creative.js')}}"></script>
    <script type="text/javascript" src="{{asset('landing/js/jquery-scrolltofixed.js')}}"></script>
    <script type="text/javascript" src="{{asset('landing/js/jquery.easing.1.3.js')}}"></script>
    <script type="text/javascript" src="{{asset('landing/js/jquery.isotope.js')}}"></script>
    <script type="text/javascript" src="{{asset('landing/js/wow.js')}}"></script>
    <script type="text/javascript" src="{{asset('landing/js/classie.js')}}"></script>
    <script src="{{asset('landing/contactform/contactform.js')}}"></script>

    @yield('additional_js')
</body>
<html>
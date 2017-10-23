<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/icons/icon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/img/icons/icon.ico') }}" type="image/x-icon">
    <!-- Core CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/nivo-lightbox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/nivo-lightbox-theme/default/default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/flexslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/datepicker3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/slippry.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/default.css') }}">
    <!-- Additional CSS Files -->
    @yield('additional_css')

    <script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>

</head>
<body class="hold-transition sidebar-mini" id="page-top" data-spy="scroll" data-target=".navbar-custom">
    <!-- page loader -->
<!--     <div id="page-loader">
      <div class="loader">
        <div class="spinner">
          <div class="spinner-container con1">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
          <div class="spinner-container con2">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
          <div class="spinner-container con3">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /page loader -->
	@yield('content')

    @if(!Auth::user())
    @endif

    <!-- Core JavaScript Files -->
    <script type="text/javascript" src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.sticky.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/slippry.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.flexslider-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/morphext.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.mb.YTPlayer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.easing.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.scrollTo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.appear.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/stellar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/nivo-lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.nicescroll.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/custom.js') }}"></script>
    <!-- Additional CSS Files -->
    @yield('additional_js')
</body>
</html>

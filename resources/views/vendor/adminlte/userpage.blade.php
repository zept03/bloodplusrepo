@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
<div class="wrapper">

        <!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <span class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img style="width:40px;height:40px" src = "{{ asset('assets/img/bloodplus/Logo2.png') }}" ></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
      <img src="{{url('/assets/img/bloodplus/LogoText.png')}}" alt="User Image"></span>
    </span>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

     
        @if(Auth::guard('web_admin')->check())
        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
        </form>
        @else
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
        </form>
        @endif
    </nav>
  </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->

        <!-- put user details here -->
        <aside class="main-sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                  @if(Auth::user()->gender == 'Male')
                  <img src="{{url('/assets/img/man.png')}}" alt="User Image"></span>
                  @elseif(Auth::user()->gender == 'Female')
                  <img src="{{url('/assets/img/user.png')}}" alt="User Image"></span>
                  @else
                  <img src="{{url('/assets/img/alien.png') }} " alt="User Image"></span>
                  @endif
                </div>
                <div class="pull-left info">
                  <p><a href = "{{url('/profile') }}" style ="color:white">{{Auth::user()->fname.' '.Auth::user()->lname}}</a><br>
                </div>
            </div>
            <hr>
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                  <li><a href="{{ url('/home') }} "><i class="fa fa-home"></i> <span>Home</span></a></li>
                  <li><a href="{{ url('/request') }} "><i class="fa fa-exclamation-triangle"></i> <span>Request</span></a></li>
                  <hr>
                  <li><a href="{{ url('/profile') }}"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a id = "logout" href="#"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->
        @include('admin.footer')
    </div>
    <!-- ./wrapper -->
@stop


@section('adminlte_js')
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
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
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script> 
    $(document).ready(function() {
    $('#inventory').DataTable();

    $("#requestId").on('click', function() {
      alert('You can only have 1 request at a time');
    });
    } );
    </script>
    <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>
    <script> 
    $("#logout").on('click', function () {
        $("#logout-form").submit(); 
    })
    </script>
    @stack('js')
    @yield('js')
@stop

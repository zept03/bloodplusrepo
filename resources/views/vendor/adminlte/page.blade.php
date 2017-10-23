@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')   
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'red') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <span class="logo-mini"><img style="width:40px;height:40px" src = "{{ asset('assets/img/bloodplus/logo1.png') }}" ></span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg">
                  <img src="{{ asset('assets/img/bloodplus/UserLogoText.png') }}" alt="User Image"></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div id = "app" style="margin-right: 50px" class="pull-right navbar-custom-menu">
                <ul class="nav navbar-nav">          <!-- Messages: style can be found in dropdown.less-->
                    <notifications 
                    :count="count" 
                    :notifications="notifications"
                    v-on:readnotif="unreadNotifications">   
                    </notifications>
                    <li class="dropdown notifications-menu">
                    <a href="#" class = "pull-right logout"><span>{{ Auth::guard('web_admin')->user()->name}}</span></a>
                    </li>
                    <li class="dropdown notifications-menu">
                    <a id ="logout" href="#" class = "pull-right logout"><span>Logout</span></a>
                    </li>
                </ul>
              </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>
        <script>
          var role = "Admin";
          var id = "{!! Auth::guard('web_admin')->user()->id !!}";
        </script>
        <form action = "{{ url ('/admin/logout') }}" style="display:none" id = "logout-form" method="post">
            {{ csrf_field() }}
        </form> 
        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{Auth::guard('web_admin')->user()->institute->picture()}} " class ="img-circle" alt="User Image"></span>
                    </div>
                    <div class="pull-left info">
                    <p><u>Philippine Red Cross</u><br>Cebu chapter
                    </div>
                    <div class="pull-left info">
                    </div>
                </div>
            <hr>
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
            @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
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
    <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop

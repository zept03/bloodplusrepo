{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::userpage')

@section('title', 'Home')

@section('content_header')
      <h1>
        Welcome Hero!
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> BloodPlus</a></li>
        <li class="active">Home</li>
      </ol>
      
@stop
    
@section('content')
@if (session('status'))
  <div id = "alertmsg" style="display:none">
    {{ session('status') }}
  </div>

  <script type ="text/javascript">
  var message = document.getElementById('alertmsg').innerHTML;
  alert(message);
  </script>
@endif  
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/nivo-lightbox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/nivo-lightbox-theme/default/default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/flexslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/slippry.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/animate.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/style.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/default.css') }}">
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
@stop

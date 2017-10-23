@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="container" style="margin-top: 90px">
  @include('layouts.homesidebar')
  <div class="col-md-8">
    <div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
      <h2> Please verify your account through your email to further avail of our services. </h2>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('resendtoken') }}">
      {{ csrf_field() }}
      <input type="submit" class ="btn btn-skin" value ="Resend Verification">
    </form>

    </div> <!-- /container-fluid -->
  </div> <!-- /col-md-8 -->
</div> <!-- /container -->

<script> 
    $("#logout").on('click', function () {
        $("#logout-form").submit(); 
    })
</script>
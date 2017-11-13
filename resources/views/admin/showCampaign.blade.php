@extends('adminlte::page')

@section('title', 'Campaign')

@section('content_header')
      <h1>
        &nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Campaign</li>
        <li class="active">{{$campaign->name}}</li>

      </ol>
@stop

@section('content') 
@if (session('status'))
  <div id = "alertmsg" style="display:none">
    {{ session('status') }}
  </div>

@endif
    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <img src ="{{$campaign->picture}}"/ style="display:cover;height:100%;width:100%">
                </div>
                <div class="col-md-8">

                        <h1>{{$campaign->name}}</h1> <br>
                        {!! $campaign->description !!} <br><br>
                        <span class="bottom-text">
                  <h3>{{$campaign->date_start->format('F j\, Y h:i A')}}<br>{{$campaign->address['place']}}</h3>
                </span>
                </div>
                
                  
            </div>
        </div>
      </div>

      <div class="box box-info">
        <div class="box-header">
        <h1>Attendees</h1>
        </div>
        <div class="box-body">
            <div class="row">        
              <div class="col-md-12">    
                @forelse($campaign->attendance as $attendance)
                  <div class ="media">
                  <div class="media-left">
                    <img src="{{$attendance->user->picture()}}" class="media-object" style="width:60px">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{$attendance->user->name()}}</h4>
                    <h4>{{$attendance->user->address['place']}}</h4>
                  </div>
                  </div>
                @empty
                  <h4>No one has joined this campaign</h4>
                @endforelse
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

@stop

@section('css')


    <link rel="stylesheet" type="text/css" href="{{ asset('theme/default.css') }}">
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
    <style>
      .bottom-text {
        vertical-align:bottom;
      }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script>
      $(document).ready(function() {

      var message = document.getElementById('alertmsg').innerHTML;
      if(message != '')
      alert(message);
      });
    </script>
@stop

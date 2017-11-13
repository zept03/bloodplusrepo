{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
      <!-- <h1>&nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
@stop

@section('content')
    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$newlyDonors}}</h3>

              <p>Recent Donors<br>({{$nxt->format(' F d, Y ')}})</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>43<sup style="font-size: 20px">%</sup></h3>

              <p>Retention Rate<br><br></p>
            </div>
            <div class="icon">
              <i class="ion-ios-pulse-strong"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">	
              <h3>{{count(Auth::guard('web_admin')->user()->institute->followers)}}</h3>

              <p>Active Blood Donors<br><br></p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$campaignCount}}</h3>

              <p>Finished Campaigns<br><br></p>
            </div>
            <div class="icon">
              <i class="ion ion-android-globe"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-8 connectedSortable">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Logs</h3>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>LogID</th>
                    <th>Message</th>
                    <th>Time</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse($logs as $log)
                  <tr>
                    <td>{{$log->id}}</td>
                    <td>{{$log->message}}</td>
                    <td>{{$log->created_at->format(' F d, Y h:i A')}}</td>
                  </tr>
                  @empty
                  <tr>
                      <td> NO LOGS </td>
                  </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat pull-right">View All Logs</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-4 connectedSortable">

        
          <!-- Calendar -->
          <div class="box box-info bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title">Calendar</h3>
              <!-- tools box -->
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
              <!-- /.row -->
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
</section></div>

@stop

@section('css')
	<link rel="stylesheet" href="{{ asset('theme/css/datepicker3.css') }}">
  <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
  <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('js')
	<script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('theme/js/dashboard.js') }}"></script>
@stop
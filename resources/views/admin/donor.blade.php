{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Donors')

@section('content_header')
      <!-- <h1>&nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Donors</li>
      </ol> -->
@stop

@section('content') 

    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div class="box box-info  ">
      <div class="box-header">
        <h3 class="box-title">Blood Donors</h3>
      </div>
      <!-- /.box-header -->
      <div class="nav-tabs-custom">
      <div class="tab-content"> 
      <div class="box-body table-responsive no-padding">
      {!! csrf_field() !!}
        <table id = "donor" class="table table-hover ">
          <thead>
            <tr>
                <th>Donor Name</th>
                <th>Gender</th>
                <th>Blood Type</th>
                <th>Contact Info</th>
                <th>Email Address</th>  
                <th>Join Date</th>
                <th>Last Donation</th>
                <th>Eligible</th>

            </tr>
        </thead>
          <tbody>  
          @foreach($donors as $donor)
            <tr>
              <td>{{$donor['name']}}</td>
              <td>{{$donor['gender']}} </td>
              <td>{{$donor['blood_type']}}</td>
              <td>{{$donor['contact']}}</td>
              <td>{{$donor['email']}}</td>
              <td>{{$donor['joinDate']}}</td>
              <td>{{$donor['last']}}</td>
              <td>{{$donor['eligible']}}</td>
              
            
            </tr>
            @endforeach 
            </tbody>

        </table>
        <!-- <input type="button" class="btn btn-sm btn-google textblast" data-toggle="modal" data-target="#sendMessage" value ="Send Textblast"> -->

      </div>


      <!-- /.box-body -->
        </div>
      </div>
      </div>
    <!-- /.box -->
    </div>
  </div>
  <!-- right col -->
<div class="modal fade modal-danger" id ="sendMessage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Send TextBlast</h4>
      </div> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
              <label class="control-label">Message:</label><br><br>
              <textarea name = "message" rows="4" cols="50" class ="form-control message" placeholder="Message here"></textarea>
              </div>
          </div>
        </div>
      <div class="modal-footer" style="margin-top:-1%">
        <button  name = "sendTextBlast" class="btn btn-outline sendTextBlast" value="Send Message" data-dismiss="modal" >Send Message</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>
<!-- /.row (main row) --> 


@stop

@section('css')
<link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
  <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('js')
<script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script> 
    $(document).ready(function() {
    $('#donor').DataTable();

    } );
    </script>
@stop
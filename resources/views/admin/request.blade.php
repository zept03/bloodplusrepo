@extends('adminlte::page')

@section('title', 'Request')

@section('content_header')
     <!--  <h1>
      &nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Request</li>
      </ol> -->
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
    <div class="box box-info  ">
      <div class="box-header">
        <h3 class="box-title">Blood requests</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
      <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Requests</a></li>
        <li><a href="#tab_2" data-toggle="tab">Ongoing</a></li>
        <li><a href="#tab_3" data-toggle="tab">Done</a></li>
        <li><a href="#tab_4" data-toggle="tab">Declined</a></li>
      </ul>
      <div class="tab-content"> 
      <div class="tab-pane active" id = "tab_1">
      <div id = "app" class="box-body table-responsive no-padding">
        <table id = "pending_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Requested by</th>
                <th>Contact Information</th>
                <th>Blood Type</th> 
                <th>Units</th>  
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @foreach($requests as $request)
            @if($request->status == 'Pending')
            <tr>
              <td> {{$request->id}} </td>
              <td> {{$request->patient_name}}  </td>
              <td> {{$request->user->fname.' '.$request->user->lname}} </td>
              <td> 0{{$request->user->contactinfo }}</td>
              <td>{{ $request->details->blood_category.' '.$request->details->blood_type }} </td>
              <td>{{ $request->details->units }} </td>
              <td>{{ $request->created_at->format(' jS \\of F Y')}} </td>
              <td><button type="button" value = "{{$request->id}}" class="btn-s btn-info decl viewBloodRequest" data-toggle="modal" data-target="#viewModal"><i class="fa fa-eye"></i></button>
            <button type="button" value = "{{$request->id}}" data-type = "request" class="btn-s btn-success decl br acceptRequest"><i class="fa fa-check" aria-hidden="true"></i></button>
            <button type="button" value = "{{$request->id}}" class="btn-s btn-danger decl declineRequest"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>
            @endif
          @endforeach 
            </tbody>
        </table>
      </div>      <!-- /.box-body --> 
      <!-- /.box-body -->
      </div>
      <div class ="tab-pane" id ="tab_2">
      <div class="box-body table-responsive no-padding">
        <table id = "ongoing_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Requested by</th>
                <th>Blood Type</th> 
                <th>Units</th>  
                <th>Available </th>
                <th>Responding </th>
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @foreach($ongoingRequests as $request)
            @if($request->status == 'Ongoing')
            <tr>
              <td> {{$request->id}} </td>
              <td> {{$request->patient_name}}  </td>
              <td> {{$request->user->fname.' '.$request->user->lname}} </td>
              <td>{{ $request->details->blood_category.' '.$request->details->blood_type }} </td>
              <td>{{ $request->details->units }} </td>
              <td> {{ count($request->details->bloodType->nonReactive())}} </td>
              <td>{{count($request->donors)}}</td>
              <td>{{ $request->created_at->format(' jS \\of F Y')}} </td>

             <td><button type="button" value = "{{$request->id}}" class="btn-s btn-info decl viewBloodRequest" data-toggle="modal" data-target="#viewModal"><i class="fa fa-eye"></i></button>
            @if(count($request->details->bloodType->nonReactive()) >= 5 || count($request->details->bloodType->nonReactive()) != 0)
             <button type="button" value = "{{$request->id}}" class="btn-s btn-warning claimRequest"><i class="fa fa-gift" aria-hidden="true"></i></button>
            @endif
            @if(count($request->details->bloodType->nonReactive()) >= $request->details->units)
            <button type="button" value = "{{$request->id}}" class="btn-s btn-success something"><i class="fa fa-check" aria-hidden="true"></i></button>
            @endif
            </td>
            </tr>
            @endif
          @endforeach 
            </tbody>
        </table>
      </div>
      </div>
      <div class ="tab-pane" id ="tab_3">
      <div class="box-body table-responsive no-padding">
        <table id = "done_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Requested by</th>
                <th>Blood Type</th> 
                <th>Units</th>  
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @foreach($requests as $request)
            @if($request->status == 'Done')
            <tr>
              <td> {{$request->id}} </td>
              <td> {{$request->patient_name}}  </td>
              <td> {{$request->user->fname.' '.$request->user->lname}} </td>  
              <td>{{ $request->details->blood_type }} </td>
              <td>{{ $request->details->units }} </td>
              <td>{{ $request->created_at->format(' jS \\of F Y')}} </td>
              <td><button type="button" value = "{{$request->id}}" class="btn-s btn-info decl viewBloodRequest" data-toggle="modal" data-target="#viewModal"><i class="fa fa-eye"></i></button>
              </td>
            </tr>
            @endif
          @endforeach 
            </tbody>
        </table>
        </div>
      <!-- /.box-body -->
        </div>
      <div class ="tab-pane" id ="tab_4">
      <div class="box-body table-responsive no-padding">
        <table id = "declined_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Requested by</th>
                <th>Blood Type</th> 
                <th>Units</th>  
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @foreach($requests as $request)
            @if($request->status == 'Declined')
            <tr>
              <td> {{$request->id}} </td>
              <td> {{$request->patient_name}}  </td>
              <td> {{$request->user->fname.' '.$request->user->lname}} </td>
              <td>{{ $request->details->blood_type }} </td>
              <td>{{ $request->details->units }} </td>
              <td>{{ $request->created_at->format(' jS \\of F Y')}} </td>
              <td><button type="button" value = "{{$request->id}}" class="btn-s btn-info decl viewBloodRequest" data-toggle="modal" data-target="#viewModal"><i class="fa fa-eye" aria-hidden="true"></i></button>
            </td>
            </tr>
            @endif
          @endforeach 
            </tbody>
        </table>
        </div>
      <!-- /.box-body -->
        </div>
      </div>
      </div>
      </div>
    <!-- /.box -->
    </div>
  </div>
  <!-- right col -->
</div>
<!-- /.row (main row) --> 
<div class="modal fade modal-danger" id ="viewModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Blood Request Form</h4>
      </div>
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker">
            <div class="form-group">
              <label class="control-label">Patient:</label>
              <input type="text" name = "pname" class="form-control" placeholder="Patient's Full Name" readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Clinical Diagnose:</label>
              <input type="text"  name ="diagnose" class="form-control" placeholder="Reason" readonly>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                  <label class="control-label">Blood Type:</label>
                   <input type="text" name="blood_type" class="form-control" placeholder="Bags" readonly>
                </div>
                <div style="" class="form-group col-md-5">
                  <label class="control-label">Blood Category:</label>
                   <input type="text" name="blood_category" class="form-control" placeholder="Bags" readonly>

                </div>
                  <div class="form-group col-md-3">
                  <label class="control-label">Bags/Units:</label>
                  <input type="number" name="units" class="form-control" placeholder="Bags" readonly>
                  </div>

              </div>
              <div class="form-group">
              <label class="control-label">Updates:</label>
                <div id ="updates">
                </div>
              </div>
                  <!-- /.input group -->
          </div>
                <!-- /.form group -->
        </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </div>
    </div>
</div>
<div class="modal fade modal-danger" id ="claimModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Notify User</h4>
      </div>
      <form id = "claimForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/request/claim') }}"> 

      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
            <p style ="margin-left:3%">Notify user for the claiming of the blood bags.</p>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Notify">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>

      </form>
      </div>
    </div>
</div>

<div class="modal fade modal-danger" id ="acceptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Accept Blood Request</h4>
      </div>
      <form id ="acceptForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/request/accept') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
            <label style ="margin-left:3%" class="control-label">Terms:</label>
            <br>
            <br>
            <p style ="margin-left:3%;color: black">You can proceed to accept via notify users, this would notify  to all your available donors. <br> Or reply to the requestor for updates.</p><br>
            <br>
            <p style ="margin-left:3%;color: black" id = "recommended"></p>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Notify">
        <button type ="button" class="btn btn-danger replybtn" id ="accptBtn" data-dismiss="modal">Accept</button> 
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade modal-danger" id ="replyModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reply</h4>
      </div>
      <form id ="replyForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/request/reply') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
              <label class="control-label">Message:</label>
              <textarea name = "message" class ="form-control" required></textarea>
              </div>
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Accept and Send">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade modal-danger" id ="declineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Decline Request Form</h4>
      </div>
      <form id ="deleteForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/request/delete') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group" style ="padding: 10px">
            <label style ="margin-left:3%" class="control-label">Terms:</label>
            <br>

            <p style ="margin-left:3%;color: black">Upon deletion of this request, it will no longer be able to be processed.</p>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Submit">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>
<div class="modal fade modal-danger" id ="doneModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Finish Transaction of Blood Request</h4>
      </div>
      <form id ="finishForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/request/finish') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
            <label style ="margin-left:3%" class="control-label">Blood Bag Id:</label>
            <br>

            <label style ="margin-left:3%" class="control-label">Terms:</label>
            <br>

            <p style ="margin-left:3%;color: black">Complete this blood request form and mark it as Done!</p>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Complete">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>

@stop

@section('css')
  <link rel="stylesheet" href="{{ asset('theme/css/datepicker3.css') }}">
  <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
  <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src ="{{ asset('js/moment.min.js')}}"></script>
    <script src ="{{ asset('js/datetime-moment.js')}}"></script>
       
    <script> 

      $(document).ready(function() {
      
            $.fn.dataTable.moment( 'MMMM DD, YYYY' );
      $.fn.dataTable.moment( 'HH:MM AA' );  

      $('#pending_requests').DataTable({
        "order": [[ 7, "asc" ]]
      });
      $('#ongoing_requests').DataTable({
        "order": [[ 7, "asc" ]]
      });
      $('#done_requests').DataTable();
      $('#declined_requests').DataTable();
      
      var message = document.getElementById('alertmsg').innerHTML;
      if(message != '')
      alert(message);
      });
    </script>
@stop

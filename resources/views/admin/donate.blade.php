@extends('adminlte::page')

@section('title', 'Donate')

@section('content_header')
      <!-- <h1>
      &nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Donate</li>
      </ol>
      -->
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
        <h3 class="box-title">Blood donations</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
      <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Today</a></li>
        <li><a href="#tab_2" data-toggle="tab">Upcoming</a></li>
        <li><a href="#tab_4" data-toggle="tab">Done</a></li>
        <li><a href="#tab_5" data-toggle="tab">Decline</a></li>
      </ul>
      <div class="tab-content"> 
      <div class="tab-pane active" id = "tab_1">
      <div id = "app" class="box-body table-responsive no-padding">
        <div class ="col-md-12">
          <table id = "pending_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>Donate ID</th>
                <th>Name</th>
                <th>Blood Type</th>  
                <th>Donate Type</th>
                <th>Request ID</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @if($todayRequests)
            @foreach($todayRequests as $donor)
              <tr>
              <td>{{ $donor->id }} </td>
          
              <td>{{ $donor->user->fname.' '.$donor->user->lname }} </td>
              <td>{{ $donor->user->bloodType}}</td>
                @if($donor->appointment_time)
              <td>VOLUNTARY</td>
              <td>n/a</td>
              <td>{{ $donor->appointment_time->format('F d Y')}}</td>
              <td>{{ $donor->appointment_time->format(' h:i A')}}</td>
                @else
              <td>RESPONSE</td>
              <td>{{$donor->bloodRequest->request->id}}</td>
              <td>{{ $donor->created_at->format('F d Y') }}</td>
              <td> ASAP</td>
              @endif
              @if($donor->status == 'Ongoing')
              <td>
              <a href ="{{url('admin/donate/'.$donor->id)}}">
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-info"><i class="fa fa-eye"></i></button>
              </a>
              <a href ="{{url('admin/donate/'.$donor->id.'/complete')}}">
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-success decl"><i class="fa fa-check" aria-hidden="true"></i></button>
            </a>
              </td>
              @else
              <td>
              <a href ="{{url('admin/donate/'.$donor->id.'/view')}}">
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-info"><i class="fa fa-eye"></i></button>
              </a>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-warning decl setRequest"><i class="fa fa-clock-o" aria-hidden="true"></i></button>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-success decl br acceptRequest"><i class="fa fa-check" aria-hidden="true"></i></button>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-danger decl declineRequest"><i class="fa fa-times" aria-hidden="true"></i></button></button>
              </td>
              @endif
              </tr>
            @endforeach
          @endif
          </tbody>
        </table>
        </div>
      
      </div>      <!-- /.box-body --> 
      <!-- /.box-body -->
      </div>
      <div class ="tab-pane" id ="tab_2">
      <div class="box-body table-responsive no-padding">
        <table id = "ongoing_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Information</th>
                <th>Blood Type</th>  
                <th>Request Type</th>
                <th>Request ID</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @if($donor_requests)
          @foreach($donor_requests as $donor)
            @if($donor->status =="Ongoing" || $donor->status == 'Pending')
            <tr>
              <td>{{$donor->id}}</td>
              <td>{{$donor->user->name()}}</td>
              <td>0{{ $donor->user->contactinfo }}</td>
              <td>{{ $donor->user->bloodType}}</td>
              @if($donor->appointment_time)
              <td>VOLUNTARY</td>
              <td>n/a</td>
              <td>{{ $donor->appointment_time->format('F d Y')}}</td>
              <td>{{ $donor->appointment_time->format(' h:i A')}}</td>
              @else
              <td>RESPONSE</td>
              <td>{{$donor->bloodRequest->request->id}}</td>
              <td>{{ $donor->created_at->format('F d Y')}}</td>
              <td>ASAP</td>
              @endif
              <td>{{ $donor->status }} </td>
              @if($donor->status == "Ongoing")
              <td>
              <a href ="{{url('admin/donate/'.$donor->id)}}">
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-info"><i class="fa fa-eye"></i></button>
              </a>

              </td>
              @else
              <td>
              <a href ="{{url('admin/donate/'.$donor->id)}}">
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-info"><i class="fa fa-eye"></i></button>
              </a>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-warning decl setRequest"><i class="fa fa-clock-o" aria-hidden="true"></i></button>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-success decl br acceptRequest"><i class="fa fa-check" aria-hidden="true"></i></button>
              <button type="button" value = "{{$donor->id}}" class="btn-s btn-danger decl declineRequest"><i class="fa fa-times" aria-hidden="true"></i></button></td>
              @endif
            </tr>
            @endif
          @endforeach
          @endif
          </tbody>
        </table>
      </div>
      </div>
      <div class ="tab-pane" id ="tab_4">
      <div class="box-body table-responsive no-padding">
        <table id = "done_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Blood Type</th>  
                <th>Request Type</th>
                <th>Request ID</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Actions</th>
            </tr>
        </thead>
          <tbody>
          @if($doneRequests)
          @foreach($doneRequests as $donor)
            @if($donor->status=="Done")
            <tr>
            <td>{{$donor->id}}</td>
            <td>{{$donor->user->name()}}</td>
            <td>{{ $donor->user->bloodType}}</td>
            @if($donor->appointment_time)
            <td>VOLUNTARY</td>
            <td>n/a</td>
            <td>{{ $donor->appointment_time->format('F d Y')}}</td>
            <td>{{ $donor->appointment_time->format(' h:i A')}}</td>
            @else
            <td>RESPONSE</td>
            <td>{{$donor->bloodRequest->request->id}}</td>
            <td>{{ $donor->created_at->format('F d Y')}}</td>
            <td>ASAP</td>
            @endif
            <td>
            <a href ="{{url('admin/donate/'.$donor->id)}}"><button type="button"  class="btn-s btn-info"><i class="fa fa-eye"></i></button></td>
            </tr>
            @endif
          @endforeach
          @endif
          </tbody>
        </table>
        </div>
      </div>
      <div class ="tab-pane" id ="tab_5">
      <div class="box-body table-responsive no-padding">
        <table id = "declined_requests" class="table table-hover ">
          <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Blood Type</th>  
                <th>Request Type</th>
                <th>Request ID</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Reason</th>
            </tr>
        </thead>
          <tbody>
          @if($cancelledRequests)
          @foreach($cancelledRequests as $donor)
            @if($donor->status=="Declined")
            <tr>
            <td>{{$donor->id}}</td>
            <td>{{$donor->user->name()}}</td>
            <td>{{ $donor->user->bloodType}}</td>
            @if($donor->appointment_time)
            <td>VOLUNTARY</td>
            <td>n/a</td>
            <td>{{ $donor->appointment_time->format('F d Y')}}</td>
            <td>{{ $donor->appointment_time->format(' h:i A')}}</td>
            @else
            <td>RESPONSE</td>
            <td>{{$donor->bloodRequest->request->id}}</td>
            <td>{{ $donor->created_at->format('F d Y')}}</td>
            <td>ASAP</td>
            @endif
            <td>{{$donor->reason}}</td>
            </tr>
            @endif
          @endforeach
          @endif
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
<div class="modal fade modal-danger" id ="setTime">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Set Appointment</h4>
      </div>
      <div class="modal-body">
      <form id ="setTimeForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/donate/settime') }}">
      {!! csrf_field() !!}
        <div id = "view" class="bootstrap-timepicker">
        <input type="hidden" id ="setId" name ="id" />
        <div class = "row">
        <div class="col-md-12">
            <label>Date of Donation</label>
           <input type="text" id = "donateDate" name="donatedate" class="form-control" placeholder = "mm/dd/yy" required>
            
        </div>
        </div>
        <div class = "row">
        <div class="col-md-12">
            <label>Time of Donation</label>
            <select type="text" class="form-control" name="donatetime" placeholder = "mm/dd/yy" required>
              <option value = "" disabled hidden selected>Select Time of Donation</option>
              <option value="08:00">8:00 AM</option>
              <option value="09:00">9:00 AM</option>
              <option value="10:00">10:00 AM</option>
              <option value="11:00">11:00 AM</option>
              <option value="13:00">01:00 PM</option>
              <option value="14:00">02:00 PM</option>
              <option value="15:00">03:00 PM</option>
              <option value="16:00">04:00 PM</option>
              <option value="17:00">05:00 PM</option>
              <option value="18:00">06:00 PM</option>
              @if ($errors->has('donatetime'))
              <span class="help-block">
              <strong>{{ $errors->first('   ') }}</strong>
               </span>
               @endif
            </select>
            </div>    
          </div>
        </div>
                <!-- /.form group -->
        </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-danger" value="Set Time">
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
        <h4 class="modal-title">Accept Donation Request</h4>
      </div>
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
      <form id ="acceptForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/donate/accept') }}"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <p style ="margin-left:3%">Do you want to accept this donation request?<br> This will immediately notify the donor that his request will is accepted.</p>  
          </div>
        </div>
      <div class="modal-footer">
        <input type="submit" name = "submitRequest" class="btn btn-danger" value="Accept">
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
        <h4 class="modal-title">Finish Donation Request</h4>
      </div>
      <form id ="finishForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/donate/finish') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group">
            <label style ="margin-left:3%" class="control-label">Terms:</label>
            <br>

            <p style ="margin-left:3%">Complete this donation request form and mark it as Done!</p>
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
<div class="modal fade modal-danger" id ="declineModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Decline Blood Donation</h4>
      </div>
      <form id ="deleteForm" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/donate/delete') }}"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="id" />
            <div class="form-group" style ="padding-left: 10px; padding-right: 10px">
              <label class="control-label">Reason:</label>
              <textarea name = "message" class ="form-control" required></textarea>
            </div>

            <div style = "padding-left: 10px; padding-right: 10px" class="form-group">
                  <label class="control-label">Blacklist</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="blacklist" value="true">
                      Yes
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="blacklist"  value="false">
                      No
                    </label>
                  </div>
                </div>
            <label class="control-label">Terms:</label>
            <br>
            <p>Upon deletion of this request, it will no longer be able to be processed.</p>
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
@stop

@section('css')
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/css/datepicker3.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src ="{{ asset('js/moment.min.js')}}"></script>
    <script src ="{{ asset('js/datetime-moment.js')}}"></script>
    <script> 
      $(document).ready(function() {

        $( "#donateDate" ).datepicker();
      $.fn.dataTable.moment( 'MMMM DD, YYYY' );
      $.fn.dataTable.moment( 'HH:MM AA' );  


      $('#pending_requests').DataTable( {
        "bLengthChange": false,
        "bInfo": false,
        "order": [[ 5, "asc" ]]
      });
      $('#ongoing_requests').DataTable();
      $('#done_requests').DataTable( {
        "order": [[ 5, "asc"]]
      });
      $('#declined_requests').DataTable({
        "order": [[ 5, "desc"]]
      });
      $('#today_requests').DataTable({
        "bLengthChange": false,
        "bInfo": false,
        "order": [[ 5, "desc"]]
      });
      var message = document.getElementById('alertmsg').innerHTML;
      if(message != '')
      {
      alert(message);
      }
      });
    </script>
@stop

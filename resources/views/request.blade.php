@extends('adminlte::userpage')

@section('title', 'Request')

@section('content_header')
      <h1>
        Blood Request
        @if($activeRequest == null)
         <a title="Request for blood" href="javascript:void(0)" data-toggle="modal" data-target="#modalhere"><span style="margin-left:10px"><i class="fa fa-plus"></i></span></a>
         @else
         <a id = "requestId" title="Request for blood" href="javascript:void(0)"><span style="margin-left:10px"><i class="fa fa-plus"></i></span></a>
         @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> BloodPlus</a></li>
        <li class="active">Request</li>
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
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">Guidelines</a></li>
    <li><a href="#tab_2" data-toggle="tab">Current</a></li>
    <li><a href="#tab_3" data-toggle="tab">History</a></li>
  </ul>
  <div class="tab-content"> 
    <div class="tab-pane active" id = "tab_1">
      <div class="box-body" style ="margin-top:0px;padding-top:0px">
          <h2>Terms</h2>
          <dl class ="dl-horizontal">
          <li>Fill in all the necessary details in the blood request form.</li>
          <li>Improper reasons will not be processed.</li>
          </dl>
          <h2>Guidelines</h2>
          <dl class ="dl-horizontal">
          <li>Click the <span style=""><i class="fa fa-plus"></i></span> putton beside the blood request title.</li>
          <li>Properly fill up the request form.</li>
          <li>Submit form</li>
          <li>Present your blood request form signed by the authorized person to the Philippine Red Cross</li>
          <li>You will be  updated by the Philippine Red Cross for your request.</li>
          </dl>           
      </div>
            <!-- /.box-body --> 
            <!-- /.box-body -->
    </div>
    <div class ="tab-pane" id ="tab_2">
      <div class="box-body table-responsive">
    		@if($activeRequest == null)
        <p> You don't have a blood request going on. </p>
        @else
        <dl class ="dl-horizontal">
          <dt> RequestId:</dt> <dd> {{ $activeRequest->uuid }} </dd>
          <dt> Patient Name: </dt> <dd> {{ $activeRequest->patient_name}} </dd>
          <dt> Institution: </dt> <dd> {{ $activeRequest->institute->institution }} </dd>
          <dt> Clinical Diagnose: </dt> <dd> {{ $activeRequest->diagnose }} </dd>
          <dt> Blood Type: </dt> <dd> {{ $activeRequest->details->blood_type }} </dd>
          <dt> Blood Category:</dt> <dd> {{ $activeRequest->details->blood_category}} </dd>
          <dt> Units Required:</dt> <dd> {{ $activeRequest->details->units}} </dd>
          <dt> Status:</dt> <dd> {{ $activeRequest->status}} </dd>
          <dt> Date Requested:</dt> <dd> {{ $activeRequest->created_at->format('l jS \\of F Y') }} </dd>
        </dl>
                @endif
     	</div>
    </div>
    <div class ="tab-pane" id ="tab_3">
    	<div class="box-body table-responsive no-padding">
        @if($historyRequest == null)
          <p> You have never completed a blood request transaction yet.</p>
        @else
        <table id = "inventory" style="width:100%" class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Patient Name</th>
              <th>Institution</th> 
              <th>Blood Type</th> 
              <th>Units</th> 
              <th>Status</th> 
              <th>Date Requested</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($historyRequest as $request)
          <tr>
            <td>{{ $request->uuid }} </td>
            <td>{{ $request->patient_name }} </td>
            <td>{{ $request->institute->institution}} </td>
            <td>{{ $request->details->blood_type }} </td>
            <td>{{ $request->details->units }} </td>
            <td>{{ $request->status }} </td>
            <td>{{ $request->created_at->format(' jS \\of F Y')}}</td>
            <td><button type="button" value = "{{$request->id}}" class="btn-xs btn-danger decl viewRequest" data-toggle="modal" data-target="#viewModal" >View</button></td>
          </tr>
          @endforeach
          </tbody>
        </table>
        @endif
 				</div>
      </div>
		</div>
	</div>

            <!-- Modal -->
<div class="modal fade modal-danger" id ="modalhere">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Request for blood</h4>
      </div>
      <div class="modal-body">
        <div class="bootstrap-timepicker">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('request') }}">	
          {!! csrf_field() !!}
          <div class="form-group">
            <label class="control-label">Patient:</label>
            <input type="text" name = "pname" class="form-control" placeholder="Patient's Full Name" required>
          </div>
          <div class="form-group">
        	  <label class="control-label">Clinical Diagnose:</label>
            <input type="text"  name ="diagnose" class="form-control" placeholder="Reason" required>
          </div>
         <div class="form-group">
        	  <label class="control-label">Institution/Blood Bank:</label>
            <select class ="form-control" name ="institution_id" required>
        		  <option value = "0" disabled hidden selected>Select Institution/Blood Bank</option>
				      @foreach($institutions as $institution)
					    <option value="{{$institution->id}}">{{$institution->institution}}</option>

			        @endforeach
            </select>
          </div>
            <div class="row">
              <div class="form-group col-md-4">
		            <label class="control-label">Blood Type:</label>
            	  <select class ="form-control" name ="bloodType" required>
            			<option value = "0" disabled hidden selected>Select Blood Type</option>
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB+">A-+</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                </select>
              </div>
              <div style="margin-left:1%;margin-right:1%" class="form-group col-md-5">
                <label class="control-label">Blood Category:</label>
                <select class ="form-control" name ="bloodCategory" required>
                  <option value = "0" disabled hidden selected>Select Blood Category</option>
                  <option value="White Blood">White Blood</option>
                  <option value="Platelet">Platelets</option>
                  <option value="Washed RBC">Washed RBC</option>
                  <option value="Packed RBC">Packed RBC</option>
                  <option value="Cryoprecipitate">Cryoprecipitate</option>
                  <option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option>
                </select>
              </div>
              <div class="form-group col-md-3">
          	  <label class="control-label">Bags/Units:</label>
                <input type="number" name="units" class="form-control" placeholder="Bags" required>
              </div>
            </div>
              <!-- /.input group -->
        </div>
            <!-- /.form group -->
  	  </div>

          <div class="modal-footer" style="margin-top:-1%">
            <input type="submit" class="btn btn-outline" value="Send Request">
            <button type="button" data-dismiss="modal" class="btn btn-outline">Close</button>
          </div>
          </form>
        </div>
  	</div> 
  </div>  
<div class="modal fade modal-danger" id ="viewModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Request for blood</h4>
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
              <textarea name = "updates" class ="form-control" style ="resize: none;" placeholder="coming soon"  readonly></textarea>
              </div>
                  <!-- /.input group -->
          </div>
                <!-- /.form group -->
        </div>
      <div class="modal-footer" style="margin-top:-1%">
        <input type="submit" class="btn btn-outline" value="Send Request">
        <button type="button" data-dismiss="modal" class="btn btn-outline">Close</button>
      </div>
      </div>
    </div>
</div>  
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

@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">
<link href="{{ asset('css/request.css') }}" rel="stylesheet">
<link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
<link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('additional_js')
<script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
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
<div class="container" style="margin-top: 90px">
	
	@include('layouts.homesidebar')
	<div class="col-md-9">
		<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
			
		<div class="tabbable-line">
			<ul class="nav nav-tabs nav-justified">
				<li class="active">
					<a href="#current-tab" data-toggle="tab">Request</a>
				</li>
				<li>
					<a href="#history-tab" data-toggle="tab">History</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="current-tab">
					
					<div class="row">
						<hr>
						<h3 style="text-align: center">REQUEST BLOOD</h3>
						<hr>
					</div>
					@if($activeRequest == null)
					<form class="form-horizontal" role="form" method="POST" action="{{ url('request') }}">	
          			{!! csrf_field() !!}
					<div class="row">
						<div class="col-md-12">
							<label>Patient's Name</label>
							<input type="text" name = "pname" class="form-control" placeholder="Patient's Full Name" required>
							<label>Clinical Diagnosis</label>
							<input type="text"  name ="diagnose" class="form-control" placeholder="Reason" required>
							<label>Blood Bank</label>
								<select class ="form-control" name ="institution_id" required>
								<option value = "" disabled hidden selected>Select Institution/Blood Bank</option>
								@foreach($institutions as $institution)
								<option value="{{$institution->id}}">{{$institution->institution}}</option>

								@endforeach
								</select>
								@if ($errors->has('institution_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('institution_id') }}</strong>
                                    </span>
                                @endif
						</div>

						<div class="col-md-4">
							<label>Blood Type</label>
							<select class ="form-control" name ="bloodType" required>
								<option value = "" disabled hidden selected>Select Blood Type</option>
								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
							</select>
							@if ($errors->has('bloodType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bloodType') }}</strong>
                                    </span>
                                @endif
						</div>

						<div class="col-md-4">
							<label>Blood Category</label>
								<select class ="form-control" name ="bloodCategory" required>
								<option value = "" disabled hidden selected>Select Blood Category</option>
								<option value="Whole Blood">Whole Blood</option>
								<option value="Platelet">Platelets</option>
								<option value="Washed RBC">Washed RBC</option>
								<option value="Packed RBC">Packed RBC</option>
								<option value="Cryoprecipitate">Cryoprecipitate</option>
								<option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option>
								</select>
								@if ($errors->has('bloodCategory'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bloodCategory') }}</strong>
                                    </span>
                                @endif
						</div>

						<div class="col-md-4">
							<label>No. of Bags</label>
							<input type="number" name="units" class="form-control" placeholder="Bags" required>
						</div>

						<div class="col-md-12">
						<br>
							<center><input type ="submit"  class="btn req-blood-btn" value = "REQUEST BLOOD"> </center>
						</div>
					</div>
					</form>
					@else

					<div class="row">
						<div class="col-md-4">
							<label>Request ID</label>
							<input type="text"  name ="id" class="form-control" value ="{{ $activeRequest->id }}" readonly>
						</div>
						<div class="col-md-4">
							<label>Status</label>
							<input type="text"  name ="id" class="form-control" value ="{{ $activeRequest->status }}" readonly>
						</div>
						<div class="col-md-12">
							<label>Patient's Name</label>
							<input type="text" name = "pname" class="form-control" value = "{{ $activeRequest->patient_name}}" readonly>
							<label>Clinical Diagnosis</label>
							<input type="text"  name ="diagnose" class="form-control" value ="{{ $activeRequest->diagnose }}" readonly>
							<label>Blood Bank</label>
							<input type="text"  name ="diagnose" class="form-control" value ="{{ $activeRequest->institute->institution }}" readonly>
						</div>

						<div class="col-md-4">
							<label>Blood Type</label>
							<input type="text"  name ="bloodType" class="form-control" value ="{{ $activeRequest->details->blood_type }}" readonly>
						</div>

						<div class="col-md-4">
							<label>Blood Category</label>
							<input type="text"  name ="bloodCategory" class="form-control" value ="{{ $activeRequest->details->blood_category }}" readonly>
						</div>

						<div class="col-md-4">
							<label>No. of Bags</label>
							<input type="text"  name ="bags" class="form-control" value ="{{ $activeRequest->details->units }}" readonly>
						</div>
						<div class="col-md-12">
							<label>Updates</label>
							<li>Waiting for confirmation</li>
							@if($activeRequest->updates)
							@foreach($activeRequest->updates as $update)
							<li>{{$update}}</li>
							@endforeach
							@endif
						</div>
						@if($activeRequest->status=='Pending')
						<div class="col-md-12">
						<br>
						<form class="form-horizontal" role="form" method="POST" action="{{ url('request/'.$activeRequest->id.'/cancel') }}">	
							{!! csrf_field() !!}
							<center><input type ="submit"  class="btn req-blood-btn" value = "CANCEL BLOOD REQUEST"> </center>
						</form>
						</div>
						@endif
					</div>					
					@endif

				</div>
				<div class="tab-pane" id="history-tab">
					<div class="row">
						<hr>
						<h3 style="text-align: center">REQUEST HISTORY</h3>
						<hr>
					</div>
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
			            <td>{{ $request->id }} </td>
			            <td>{{ $request->patient_name }} </td>
			            <td>{{ $request->institute->institution}} </td>
			            <td>{{ $request->details->blood_type }} </td>
			            <td>{{ $request->details->units }} </td>
			            <td>{{ $request->status }} </td>
			            <td>{{ $request->created_at->format(' jS \\of F Y')}}</td>
			            <td><a href ="{{url('/request/'.$request->id)}}"><button type="button" value = "{{$request->id}}" class="btn-xs req-blood-btn viewRequest" data-toggle="modal" data-target="#viewModal" >View</button></a></td>
			          </tr>
			          @endforeach
			          </tbody>
			        </table>
			        @endif
				</div>
				</div>
		</div>
		</div> <!-- /container-fluid -->
	</div> <!-- /col-md-8 -->
</div> <!-- /container -->

<script> 
    $("#logout").on('click', function () {
        $("#logout-form").submit(); 
    })

    $("#inventory").DataTable();
</script>
@stop
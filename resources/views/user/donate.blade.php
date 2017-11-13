@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">
<link href="{{ asset('css/request.css') }}" rel="stylesheet">
<link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
<link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('theme/css/datepicker3.css') }}" >
@stop

@section('additional_js')
<script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
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
						<h3 style="text-align: center">DONATE BLOOD</h3>
						<hr>
					</div>
					@if($nextDonation)
							<h3>You can donate again on {{$nextDonation->format('jS \\of F Y')}} onwards</h3>
							@if($monthLeft != 0)
							<h3>You only have {{ $monthLeft }} month(s) and {{ $daysLeft }} day(s) left</h3>
							@else
							<h3>You only have {{ $daysLeft }} day(s) left</h3>	
							@endif

					
					@elseif($activeRequest == null)
					<form class="form-horizontal" role="form" method="POST" action="{{ url('donate') }}">	
          			{!! csrf_field() !!}
					<div class="row">
						<div class="col-md-12">
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
						<div class="col-md-6">
							<label>Date of Donation</label>
							<input id="donatedate" type="text" class="form-control" name="donatedate" placeholder = "mm/dd/yy" required>

                                @if ($errors->has('donatedate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('donatedate') }}</strong>
                                    </span>
                                @endif
						</div>
						<div class="col-md-6">
							<label>Time of Donation</label>
							<select type="text" class="form-control" name="donatetime" required>
								<option value = "" disabled hidden selected>Select Time of Donation</option>
								<option value="08:00">8:00 AM</option>
								<option value="09:00">9:00 AM</option>
								<option value="10:00">10:00 AM</option>
								<option value="11:00">11:00 AM</option>
								<option value="13:00">01:00 PM</option>
								<option value="14:00">02:00 PM</option>
								<option value="15:00">03:00 PM</option>
								<option value="16:00">04:00 PM</option>
                                @if ($errors->has('donatetime'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('donatetime') }}</strong>
                                    </span>
                                @endif
                                </select>
						</div>
						<div class="col-md-12">
						<br>
							<center><input type ="submit"  class="btn req-blood-btn" value = "DOANTE BLOOD"> </center>
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
							<label>Blood Bank</label>
							<input type="text" class="form-control" value ="{{$activeRequest->institute->institution}}" readonly>
						</div>
						@if($activeRequest->appointment_time != null)
						<div class="col-md-6">
							<label>Date Requested</label>
							<input type="text" name="units" class="form-control" value ="{{$activeRequest->appointment_time->format('jS \\of F Y')}}" readonly>
						</div>
						<div class="col-md-6">
							<label>Appointment Time</label>
							<input type="text" name="units" class="form-control" value ="{{$activeRequest->appointment_time->format('h:i A')}}" readonly>
						</div>
						@else
						<div class="col-md-6">
							<label>Date Requested</label>
							<input type="text" name="units" class="form-control" value ="{{$activeRequest->created_at->format('jS \\of F Y')}}" readonly>
						</div>
						<div class="col-md-6">
							<label>Appointment Time</label>
							<input type="text" name="units" class="form-control" value ="{{$activeRequest->created_at->format('h:i A')}}" readonly>
						</div>
						@endif

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
							<form class="form-horizontal" role="form" method="POST" action="{{ url('donate/'.$activeRequest->id.'/cancel') }}">	
							{!! csrf_field() !!}
							<center><input type ="submit"  class="btn req-blood-btn" value = "CANCEL DONATE REQUEST"> </center>
							</form>
						</div>
						@endif
					</div>	
					@endif

				</div>
				<div class="tab-pane" id="history-tab">
					<div class="row">
						<hr>
						<h3 style="text-align: center">DONATE HISTORY</h3>
						<hr>
					</div>
					@if($historyRequest == null)
			          <p> You have never donated. Start your first donation now!.</p>
			        @else
			        <table id = "inventory" style="width:100%" class="table">
			          <thead>
			            <tr>
			              <th>ID</th>
			              <th>Institution</th> 
			              <th>Date of Appointment</th> 
			              <th>Time of Appointment</th> 
			              <th>Status</th> 
			              <th>Actions</th>
			            </tr>
			          </thead>
			          <tbody>
			          @foreach($historyRequest as $request)
			          <tr>
			          <td>{{$request->id}}</td>
			          <td>{{$request->institute->institution}}</td>
			          @if($request->appointment_time)
			          <td>{{$request->appointment_time->format('jS \\of F Y')}}</td>
			          <td>{{$request->appointment_time->format('h:i A')}}</td>
			          @else
			          <td>{{$request->created_at->format('jS \\of F Y')}}</td>
			          <td>ASAP</td>
			          @endif
			          <td>{{$request->status}}</td>  
			            <td><a href ="{{url('/donate/'.$request->id)}}"> <button type="button" value = "{{$request->id}}" class="btn-xs req-blood-btn viewRequest" data-toggle="modal" data-target="#viewModal">View</button></a></td>
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

    $("#inventory").dataTable();
	$( "#donatedate" ).datepicker();
</script>
@stop
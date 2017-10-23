<div class="col-md-4">
	<div class="row user-basic-info">
		@if(!$user)
		<h4 style="text-transform: uppercase;">{{Auth::user()->fname.' '.Auth::user()->lname}}</h4>
			<h5>Blood Type: {{Auth::user()->bloodType}}</h5>
			@if(Auth::user()->address['place'])
			<h5>{{Auth::user()->address['place']}}</h5>
			@endif
		@else
		<h4 style="text-transform: uppercase;">{{$user->fname.' '.$user->lname}}</h4>
 
			@if($user->address['place'])
			<span>{{$user->address['place']}}</span>
			<br>
			@endif
		@endif
	</div>

			<br>
			@if(!$user)

				<div class="row history-section">
					<h3 style="text-transform: uppercase;">History</h3>
						<table class="table" style="border: 0">
						
						@foreach($logs as $log)
							<tr>
								<td>{{$log->message}}</td>
								<td>{{$log->created_at->toDateString()}}</td>
							</tr>
						@endforeach
		</table>
	</div>
						@endif
	
</div>
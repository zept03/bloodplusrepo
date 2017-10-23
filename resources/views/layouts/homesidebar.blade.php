	<div class="col-md-3">
		
		<div class="panel navbar-fixed-left">
			<div class="panel-body" style="padding-top: 0px;">
				<div class="row">
					<div class="sidebar-first-row">
					<center>
					@if(!Auth::user()->picture)
		  			@if(Auth::user()->gender == 'Male')
		  			<img class="img-responsive sidebar-avatar" src="{{asset('storage/avatars/profile/man.png')}}"/>
		  			@else
		  			<img class="img-responsive sidebar-avatar" src="{{asset('storage/avatars/profile/woman.png')}}"/>
		  			@endif
		  			@else
		  			<img class="img-responsive sidebar-avatar" src ="{{Auth::user()->picture}}"/>
		  			@endif
		  				<a href ="{{url('/profile')}}">
						<h4>{{Auth::user()->fname.' '.Auth::user()->lname}}</h4>
						</a>
						<h5>Blood Type: {{Auth::user()->bloodType}}</h5>
					</center>
					</div>
				</div>
				<div class="row sidebar-second-row">
					<ul style="padding-left: 0px;">
						<li><h5><a href = "{{url('/request')}}"> REQUEST BLOOD</a></h5></li>
						<li><h5><a href = "{{url('/donate')}}"> DONATE BLOOD</a></h5></li>
					</ul>
				</div>
				<div class="row" style="background: #fff">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				</div>
			</div>
		</div>

	</div>
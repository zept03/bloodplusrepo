	@extends('layouts.app')

	@section('title','BloodPlus')
	@section('additional_css')

	<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
	<link href="{{ asset('css/index.css') }}" rel="stylesheet">
	@stop
	@section('content')
	<div class="container" style="margin-top: 30px;">

		  <div class="row"> 	
		  	<div class="container-banner">
		  	@if(!$user->banner())
		  	<div class="banner-container" style ="width:100% !important; background-image: url('{{url('/assets/img/slides/bb5.jpg')}}')">
		  	@else
		  	<div class="banner-container" style ="width:100% !important; background-image: url('{{$user->banner()}}')">
		  	@endif
		  </div>
		  <div class="row">
		  	<div class="image-profile">
		  		<div class="container-profile-photo">
		  		@if(!$user->picture())
		  			@if($user->gender == 'Male')
		  			<img class="img-responsive" src="{{asset('storage/avatars/profile/man.png')}}"/>
		  			@else
		  			<img class="img-responsive" src="{{asset('storage/avatars/profile/woman.png')}}"/>
		  			@endif
		  		@else
		  			<img class="img-responsive" src ="{{$user->picture()}}"/>
		  		@endif
		  	</div>
		  </div>

	     <div class="row">
	      	<div class="container counter-container">      		
	      		<ul class="tiles-counter">
	      			<li>
	      				<ul class="counter-details counter-1">
	      					<li class="counter-header">{{$donateCount}}</li>
	      					<li>Blood Donations</li>
	      				</ul>

	      			</li>
	      			<li>
	      				<ul class="counter-details counter-2">
	      					<li class="counter-header">{{count($user->followers)}}</li>
	      					<li>Followers</li>
	      				</ul>
	      				
	      			</li>
	      			<li>
	      				<ul class="counter-details counter-3">
	      					<li class="counter-header">{{count($user->followedInstitutions) + count($user->followedUsers)}}</li>
	      					<li>Following</li>
	      				</ul>
	      				
	      			</li>
	      		</ul>
	      		@if($following)
	      		<button value = "{{$user->id}}" class="btn-follow pull-right followButton following" rel="6">Following</button>
	      		@else
	      		<button value = "{{$user->id}}" class="btn-follow pull-right followButton " rel="6">Follow</button>
	      		@endif
	      	</div>
	      </div>

	      <br>

		    <div class="row">
				<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">

					<div class="tabbable-line">
						<ul class="nav nav-tabs nav-justified">
							<li class="active">
								<a href="#posts-tab" data-toggle="tab">Posts</a>
							</li>
							<li>
								<a href="#followers-tab" data-toggle="tab">Followers</a>
							</li>
							<li>
								<a href="#following-tab" data-toggle="tab">Following</a>
							</li>
							<li>
								<a href="#edit-profile-tab" data-toggle="tab">Profile</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="posts-tab">
								<div class="container-fluid">
								<!-- starts here ang sidebar profile -->
									@include('layouts.sidebar')
								<!-- end here ang sidebar profile -->
									<div class="col-md-8 col-offset-md-2">
										<!-- 
											posts
										 -->
									 @forelse($posts as $post)
									<div class="panel panel-default">
									  <div class="panel-body">
										<ul class="card-header-ul">
											<li><img src="{{$post->initiated->picture()}}" class="card-header-img"></li>
											<li>
												<div class="row card-header-row">
													<h5>{{$post->initiated->name()}}</h5>
													<span class="card-header-address">Cebu City</span>
												</div>
											</li>
										</ul>
										<p>{{$post->message}}</p>
									  	<img src="{{$post->picture}}" class="img-responsive">
									  	<br>
									  	<a href="#"><span class="glyphicon glyphicon-heart"></span></a>

									  </div>			  
									</div>
									@empty
									<div class="panel panel-default">
									  <div class="panel-body">
											<ul class="card-header-ul">
												<h2> This user hasn't posted anything yet. </h2>
											</ul>
									  </div>			  
									</div>
									@endforelse
									</div>
								</div>
							</div>
							<div class="tab-pane" id="followers-tab">
								<div class="container-fluid">
									<!-- starts here ang sidebar profile -->
									@include('layouts.sidebar')
									<!-- end here ang sidebar profile -->
									<div class="col-md-8">
										<div class="well" style="background: #fff; max-height: 740px; overflow-y: scroll;">
										<div class="row">
											@if($followers)
											<?php $count = 0 ?>
											@forelse($mutualFollowers as $follower)
											@if($count % 3 == 0)
											<div class ="row">
											@endif
											<div class="col-md-4">
								                <div class="card">
							               			@if($follower->banner())
						                            <img class="card-img-top" src="{{$follower->banner()}}">
						                            @else
						                            <img class="card-img-top" src="{{asset('assets/img/slides/bb2.jpg')}}">
								                    @endif
								                    <div class="card-block">
								                        <figure class="profile">
								                            <img src="{{$follower->picture()}}" class="profile-avatar">
								                        </figure>
								                        <a href="{{ url('/user/'.$follower->id.'')}}"><h4 class="card-title">{{$follower->name()}}</h4></a>
								                        @if($follower->id != Auth::user()->id)
								                            <center><button value = "{{$follower->id}}" class="btn-follow followButton following" rel="6">Following</button></center>
							                            @endif
								                    </div>
								                </div>
								            </div>
								            <?php $count++?>
								            @if($count % 3 == 0)
											</div>
											@endif
								            @empty
								            @endforelse
								            @forelse($notMutualFollowers as $follower)
								            @if($count % 3 == 0)
											<div class ="row">
											@endif
											<div class="col-md-4">
								                <div class="card">
							               			@if($follower->banner())
						                            <img class="card-img-top" src="{{$follower->banner()}}">
						                            @else
						                            <img class="card-img-top" src="{{asset('assets/img/slides/bb2.jpg')}}">
								                    @endif
								                    <div class="card-block">
								                        <figure class="profile">
								                            <img src="{{$follower->picture()}}" class="profile-avatar">
								                        </figure>
								                        <a href="{{ url('/user/'.$follower->id.'')}}"><h4 class="card-title">{{$follower->name()}}</h4></a>
								                        <div class="card-text">
								                            <center><button value = "{{$follower->id}}" class="btn-follow followButton" rel="6">Follow</button></center>
								                        </div>
								                    </div>
								                </div>
								            </div>
								            <?php $count++?>
								            @if($count % 3 == 0)
											</div>
											@endif
								            @empty
								            @endforelse
								            @else
								            <h1>This user has no followers</h1>
								            @endif
										</div>
									</div>	
										
									</div>
								</div>
							</div>
							<div class="tab-pane" id="following-tab">
								<div class="container-fluid">
									<!-- starts here ang sidebar profile -->
									@include('layouts.sidebar')
									<!-- end here ang sidebar profile -->
									<div class="col-md-8">

										<div class="well" style="background: #fff; max-height: 740px; overflow-y: scroll;">
										<div class="row">

											@if($followees)
											<?php $count = 0 ?>
											@forelse($mutualFollowing as $followee)
											@if($count % 3 == 0)
											<div class ="row">
											@endif
											<div class="col-md-4">
								                <div class="card">
							               			@if($followee->banner())
						                            <img class="card-img-top" src="{{$followee->banner()}}">
						                            @else
						                            <img class="card-img-top" src="{{asset('assets/img/slides/bb2.jpg')}}">
								                    @endif
								                    <div class="card-block">
								                        <figure class="profile">
								                            <img src="{{$followee->picture()}}" class="profile-avatar">
								                        </figure>
								                        <a href="{{ url('/user/'.$followee->id.'')}}"><h4 class="card-title">{{$followee->name()}}</h4></a>
								                        <div class="card-text">
								                        	@if($followee->id != Auth::user()->id)
								                            <center><button value = "{{$followee->id}}" class="btn-follow followButton following" rel="6">Following</button></center>
								                            @endif
								                        </div>
								                    </div>
								                </div>
								            </div>
								            <?php $count++?>
								            @if($count % 3 == 0)
											</div>
											@endif
								            @empty
								            @endforelse
								            @forelse($notMutualFollowing as $followee)
								            @if($count % 3 == 0)
											<div class ="row">
											@endif
											<div class="col-md-4">
								                <div class="card">
							               			@if($followee->banner())
						                            <img class="card-img-top" src="{{$followee->banner()}}">
						                            @else
						                            <img class="card-img-top" src="{{asset('assets/img/slides/bb2.jpg')}}">
								                    @endif
								                    <div class="card-block">
								                        <figure class="profile">
								                            <img src="{{$followee->picture()}}" class="profile-avatar">
								                        </figure>
								                        <a href="{{ url('/user/'.$followee->id.'')}}"><h4 class="card-title">{{$followee->name()}}</h4></a>
								                        <div class="card-text">
								                            <center><button value = "{{$followee->id}}" class="btn-follow followButton following" rel="6">Following</button></center>
								                        </div>
								                    </div>
								                </div>
								            </div>
								            <?php $count++?>
								            @if($count % 3 == 0)
											</div>
											@endif
								            @empty
								            @endforelse
								            @else
								            <h1>This user hasn't followed anyone!</h1>
								            @endif
										</div>
									</div>
								</div>	
							</div>
							</div>
							<div class="tab-pane" id="edit-profile-tab">
								<div class="container-fluid">
								<!-- starts here ang sidebar profile -->
									@include('layouts.sidebar')
								<!-- end here ang sidebar profile -->
									<div class="col-md-8">
										<!-- 
											posts
										 -->
									<div class="panel panel-default">

								  <div class="panel-body">
											<h4><span class="glyphicon glyphicon-user"></span>Personal Information</h4>
											<hr>
											<dt>Name:</dt> <dd> {{ $user->name() }} </dd>
										          <dt>Address: </dt> <dd> {{ $user->address['place'] }}</dd>
										          <dt>Gender: </dt> <dd> {{ $user->gender }}</dd>
										          <dt>Blood Type:</dt> <dd> {{ $user->bloodType }}</dd> 
										          <dt>Date of Birth</dt><dd> {{ $user->dob->format(' jS \\of F Y')}}</dd>

											<hr>
											<h4><span class="glyphicon glyphicon-phone"></span>Contact Information</h4>
											<hr>
											<dt>Email Address:</dt> <dd> {{ $user->email }} </dd>
											<dt>Contact Number:</dt> <dd> 0{{ $user->contactinfo }} </dd>
											<hr>


									  </div>			  
									</div>

									</div>
								</div>
							</div>
						</div>
					</div>
						
				</div>
			</div>

	    
	</div>

	<script type="text/javascript">

		// The rel attribute is the userID you would want to follow

		$('button.followButton').on('click', function(e){
		    e.preventDefault();
		    $button = $(this);
		    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		    
		    if($button.hasClass('following')){
		        var url = "{{ url('/user') }}/"+$(this).val()+"/unfollow";
		        console.log(url);
		        $.ajax({
		            method: "post",
		            url: url,
		            data: {'_token': CSRF_TOKEN
		                },
		            success:function(data) {
		                console.log(data);

		            },
		            error: function(xhr) {
		                console.log(xhr.status);
		            }
		        });
		        
		        $button.removeClass('following');
		        $button.removeClass('unfollow');
		        $button.text('Follow');
		    } else {
		        
		        var url = "{{ url('/user') }}/"+$(this).val()+"/follow";
		        console.log(url);
		        $.ajax({
		            method: "post",
		            url: url,
		            data: {'_token': CSRF_TOKEN
		                },
		            success:function(data) {
		                console.log(data);

		            },
		            error: function(xhr) {
		                console.log(xhr.status);
		            }
		        });
		        
		        $button.addClass('following');
		        $button.text('Following');
	    }
		});

		$('button.followButton').hover(function(){
		     $button = $(this);
		    if($button.hasClass('following')){
		        $button.addClass('unfollow');
		        $button.text('Unfollow');
		    }
		}, function(){
		    if($button.hasClass('following')){
		        $button.removeClass('unfollow');
		        $button.text('Following');
		    }
		});

		$("#banner-file").on("change",function(){
			$("#banner-form").submit();
		});	
		$("#anchor-file").on("change",function(){
			$("#pp-form").submit();
		});
		function openfile(){
			document.getElementById('anchor-file').click();
		}

		function bannerfile(){
			document.getElementById('banner-file').click();
		}
	</script>
	@stop
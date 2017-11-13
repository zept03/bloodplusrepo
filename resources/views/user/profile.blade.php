	@extends('layouts.app')

	@section('title','BloodPlus')
	@section('additional_css')

	<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
	<link href="{{ asset('css/index.css') }}" rel="stylesheet">
	<style>
	dt { width: 150px; float: left; clear: left; font-size: 18px; }
	dd { font-size: 18px; margin-right: 1%; white-space: nowrap;}
	.activity  dt { width: 250px; }
	</style>
	@stop
	@section('content')
	<div class="container" style="margin-top: 30px;">

		  <div class="row"> 	
		  	<div class="container-banner">
		  	@if(!Auth::user()->banner())
		  	<div class="banner-container" style ="width:100% !important; background-image: url('{{url('/assets/img/slides/bb5.jpg')}}')">
		  	@else
		  	<div class="banner-container" style ="width:100% !important; background-image: url('{{Auth::user()->banner()}}')">
		  	@endif
		  	<div class="banner-overlay"></div>
		  		<form id ="banner-form" method ="post" action = "{{url('/user/'.Auth::user()->id.'/changebanner')}}" enctype="multipart/form-data">
		  		  {!!csrf_field()!!}
		  		  <div class="change-banner-button"><a href="#" onclick="bannerfile()"> Change Banner </a><input id="banner-file" name ="banner-input" type="file" accept="image/*" style="display: none;"></div>
	  		    </form>
			  </div>
		    </div>
		  </div>
		  <div class="row">
		  	<div class="image-profile">
		  		<div class="container-profile-photo">
		  		@if(!Auth::user()->picture())
		  			@if(Auth::user()->gender == 'Male')
		  			<img class="img-responsive" src="{{asset('storage/avatars/profile/man.png')}}"/>
		  			@else
		  			<img class="img-responsive" src="{{asset('storage/avatars/profile/woman.png')}}"/>
		  			@endif
		  		@else
		  			<img class="img-responsive" src ="{{Auth::user()->picture()}}"/>
		  		@endif
		  		  <div class="overlay"></div>
		  		  <form id ="pp-form" method ="post" action = "{{url('/user/'.Auth::user()->id.'/changepp')}}" enctype="multipart/form-data" >
		  		  {!!csrf_field()!!}
		  		  <div class="change-photo-button"><a href="#" onclick="openfile()"> Change Photo </a><input id="anchor-file" name ="profile-input" type="file" accept="image/*" style="display: none;"></div>
		  		  </form>
		  		</div>
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
	      					<li class="counter-header">{{count(Auth::user()->followers)}}</li>
	      					<li>Followers</li>
	      				</ul>
	      				
	      			</li>
	      			<li>
	      				<ul class="counter-details counter-3">
	      					<li class="counter-header">{{count(Auth::user()->followedInstitutions) + count(Auth::user()->followedUsers)}}</li>
	      					<li>Following</li>
	      				</ul>
	      				
	      			</li>
	      		</ul>
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
								<a href="#edit-profile-tab" data-toggle="tab">About</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="posts-tab">
								<div class="container-fluid">
								<!-- starts here ang sidebar profile -->
									@include('layouts.sidebar')
								<!-- end here ang sidebar profile -->
									<div class="col-md-8">
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
												<h2> No posts yet. Get started now! </h2>
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
											@if($followers)
											<?php $count = 0 ?>
											@forelse($mutuals as $follower)
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
								                        <a href="{{ url('/user/'.$follower->id.'')  }}"><h4 class="card-title">{{$follower->name()}}</h4></a>
								                        <div class="card-text">
								                        	<br>
								                            <center><button value = "{{$follower->id}}" class="btn-follow followButton following" rel="6">Following</button></center>
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

								            @forelse($notMutuals as $follower)
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
								                        <a href="{{ url('/user/'.$follower->id.'') }}"><h4 class="card-title">{{$follower->name()}}</h4></a>
								                        <div class="card-text">
								                        	<br>
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
								            <h1>No one has followed you yet poor you!</h1>
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
											<?php $count = 0 ?>
											@forelse($followees as $followee)
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
								                        	<br>
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
								            <h1>You have not yet followed anyone!</h1>
								            @endforelse
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
								  	<div class ="row">
								  		<div class ="col-md-12">
								  			<hr>
											<h3><span style="margin-right: 3%" class="glyphicon glyphicon-user"></span>Personal Information</h3>
											<hr style ="margin-bottom: 2%">
											<dl>
											<dt>Name:</dt> <dd> {{ Auth::user()->name() }} </dd>
										          <dt>Address: </dt> <dd> {{ Auth::user()->address['place'] }}</dd>
										          <dt>Gender: </dt> <dd> {{ Auth::user()->gender }}</dd>
										          <dt>Blood Type:</dt> <dd> {{ Auth::user()->bloodType }}</dd> 
										          <dt>Date of Birth</dt><dd> {{ Auth::user()->dob->format(' jS \\of F Y')}}</dd>
								          	<hr>
											<h3><span style="margin-right: 3%" class="glyphicon glyphicon-phone"></span>Contact Information</h3>
											<hr style ="margin-bottom: 2%">
											<dt>Email Address:</dt> <dd> {{ Auth::user()->email }} </dd>
											<dt>Contact Number:</dt> <dd> 0{{ Auth::user()->contactinfo }} </dd>
											</dl>

								  		</div>
								  		<div class ="col-md-12 activity">
								  			<hr>
											<h3><span style="margin-right: 3%" class="glyphicon glyphicon-tint"></span>Activities</h3>
											<hr style ="margin-bottom: 2%">
											<dl>
											<dt> Number of Blood Requests </dt> <dd> {{$requestCount}}</dd>
											<dt> Number of Blood donations </dt> <dd> {{$donateCount}}</dd>
											<dt> Campaigns Joined </dt> <dd> </dd>
											</dl>
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
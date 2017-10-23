@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">

@stop

@section('content')
<div class="container" style="margin-top: 90px">
	@include('layouts.homesidebar')
	<div class="col-md-8">
		<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
	
		<div class="tabbable-line">
			<ul class="nav nav-tabs nav-justified searchtabs">
				<li class="active">
					<a href="#users-tab" data-toggle="tab">Users</a>
				</li>
				<li>
					<a href="#campaigns-tab" data-toggle="tab">Organizations</a>
				</li>
				<li>
					<a href="#orgs-tab" data-toggle="tab">Campaigns</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane search active" id="users-tab">
					@forelse($users as $user)
					<div class="media">
					    <div class="media-left">
					      <img src="{{$user['picture']}}" class="media-object" style="width:60px">
					    </div>
					    <div class="media-body">
					      <a href = "{{url('/user/'.$user['id'].'')}}"><h4 class="media-heading">{{$user['name']}}</h4></a>
					      <p>{{$user['address']}}</p>
					    </div>
				    </div>
				  	<hr>
				  	@empty
				  		<p> no users with that name</p>
				  	@endforelse
				</div>
				<div class="tab-pane search" id="campaigns-tab">
					@forelse($orgs as $org)
					<div class="media">
					    <div class="media-left">
					      <img src="{{$org['picture']}}" class="media-object" style="width:60px">
					    </div>
					    <div class="media-body">
					      <a href = "{{url('/user/'.$org['id'].'')}}"><h4 class="media-heading">{{$org['name']}}</h4></a>
					      <p>{{$org['address']}}</p>
					    </div>
				    </div>
				  	<hr>
				  	@empty
				  		<p> no organizations with that name</p>
				  	@endforelse
				</div>
			</div>
		</div>	

		</div>
		</div>


		</div> <!-- /container-fluid -->
	</div> <!-- /col-md-8 -->
</div> <!-- /container -->

@stop
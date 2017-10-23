@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">

@stop

@section('content')
<div class="container" style="margin-top: 90px">
	@include('layouts.homesidebar')
	<div class="col-md-9">
		<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
			
			<div class ="panel panel-default">
				<div class="panel-body">
					<div class ="row">
						<div class="col-md-5">
						<img src="{{$campaign->picture}}" class="img-responsive">
						</div>
						<div class="col-md-7">
						<h4>{{$campaign->initiated->name()}}</h4>
						<h1>{{$campaign->name}}</h1>
						{!! $campaign->description !!}
						<h4>{{$campaign->date_start->format('F j\, Y h:i A')}}<br>{{$campaign->address['place']}}</h4>
						</div>
					</div>
				</div>
			</div>

			<div class ="panel panel-default">
				<div class="panel-body">
						<h4>Discussions:</h4>
						<h1>{{$campaign->name}}</h1>
						{!! $campaign->description !!}
						<h4>{{$campaign->date_start->format('F j\, Y h:i A')}}<br>{{$campaign->address['place']}}</h4>
					</div>
				</div>
			</div>
			discussions



		</div> <!-- /container-fluid -->
	</div> <!-- /col-md-8 -->
</div> <!-- /container -->

@stop
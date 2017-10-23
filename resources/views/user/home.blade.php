@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/index.css') }}" rel="stylesheet">

@stop

@section('content')
<div class="container" style="margin-top: 90px">
	@include('layouts.homesidebar')
	<div class="col-md-8">
		<div class="container-fluid" style="padding-left: 0px; padding-right: 0px">
			
			@if($pinnedPost == 'active')
			<div class ="panel panel-defualt">
				<div class="panel-body">
					"YOU HAVE ONGOING DONATIONS. DETAILS HERE. {{$activePinnedPost->request->institute->name()}}
				</div>
			</div>
			@elseif($pinnedPost)
			<div class ="panel panel-defualt">
				<div class="panel-body">
					<center>

					YOU CAN DONATE TO THIS PATIENT!.
      				<form id="search" method="post" action="{{ url('/request/'.$pinnedPost->id.'/donate') }}">
      					{{csrf_field()}}
						<input type= "submit" value ="Donate Now!">
					</form>
					<br>

					<img src="{{$pinnedPost->post()->first()->picture}}" class="img-responsive">
					</center>
				</div>
			</div>
			@endif


			@foreach($posts as $post)
			<div class="panel panel-default">

			  <div class="panel-body">
				<ul class="card-header-ul">
					<li><img src="{{$post['userpic'] }}" class="card-header-img"></li>
					<li>
							<h5>{{$post['name']}}</h5>
							<span>{{ $post['time']}}</span>
							<span class="card-header-address">Cebu City</span>
					</li>
				</ul>
				<p>{{$post['message']}}</p>
				<center>
				@if($post['class'] == 'Campaign')
					<a href ="{{url('/campaign/'.$post['class_id'])}}">
				@endif
				<img src="{{$post['picture']}}" class="img-responsive">
				@if($post['class'] == 'Campaign')
					</a>
				@endif
				</center>
			  	<br>
			  	@if($post['liked'])
			  	<a href="">
			  	<span class="glyphicon glyphicon-heart heartReact activeHeart" data-value="{{$post['id']}}"></span>
			  	</a>
			  	@else
			  	<a href="">
			  	<span class="glyphicon glyphicon-heart heartReact" data-value="{{$post['id']}}"></span>
			  	</a>	
			  	@endif
			  	@if($post['count'] != 0)
			  	<small class="count">{{$post['count']}}</small>
			  	@else
			  	<small class="count">{{$post['count']}}</small>
			  	@endif
			  </div>			  
			</div>
			@endforeach		

		</div> <!-- /container-fluid -->
	</div> <!-- /col-md-8 -->
</div> <!-- /container -->

<script> 
   $('.heartReact').on('click', function(e){
		    e.preventDefault();
		    $button = $(this);	
		    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		    if($button.hasClass('activeHeart')){
		        var url = "{{ url('/post') }}/"+$(this).data("value")+"/unreact";
		        console.log(url);
		        $.ajax({
		            method: "post",
		            url: url,
		            data: {'_token': CSRF_TOKEN
		                },
		            success:function(data) {
		                console.log(data);
		                var number = $(e.target).parent().next().text();
		                number--;
		                $(e.target).parent().next().text(number);

		            },
		            error: function(xhr) {
		                console.log(xhr.status);
		            }
		        });	
		        //$.ajax(); Do unlike
		        
		        $button.removeClass('activeHeart');
		        // $button.removeClass('unfollow');
		        // $button.text('Follow');
		    } else {
		        
		        var url = "{{ url('/post') }}/"+$(this).data("value")+"/react";
		        console.log(url);
		        $.ajax({
		            method: "post",
		            url: url,
		            data: {'_token': CSRF_TOKEN
		                },
		            success:function(data) {
		                console.log(data);
		                var number = $(e.target).parent().next().text();
		                number++;
		                $(e.target).parent().next().text(number);

		            },
		            error: function(xhr) {
		                console.log(xhr.status);
		            }
		        });	
		        
		        $button.addClass('activeHeart');
		        // $button.text('Following');
	    }
	});
</script>
@stop
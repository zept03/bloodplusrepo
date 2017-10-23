@extends('layouts.master')

@section('additional_css')
<link href="{{ asset('theme/css/fullcalendar.min.css') }}"   rel="stylesheet" />
<link href="{{ asset('theme/css/fullcalendar.print.min.css') }}"   media = 'print' rel="stylesheet" />
@stop


@section('additional_js')
<script type="text/javascript" src="{{ asset('theme/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('theme/js/fullcalendar.min.js') }}"></script>
@stop

@section('title','BloodPlus')
@section('content')
@include('layouts.navigation')
  <section id="works" class="home-section color-dark text-center bg-white">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
					<div class="section-heading text-center">
					<h2 class="h-bold">Campaign</h2>
					<div class="divider-header"></div>
					<p>We provide you with the advocacies of our partnered health institutions and allow you to join their spearheaded campaigns.</p>
					</div>
					</div>
				</div>
			</div>

		</div>
		<hr>
	<div class="container">
      <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" >
          <div class="wow bounceInUp" data-wow-delay="0.4s">
                <div id="owl-works" class="owl-carousel">
                    <div class="item"><a href="{{url('/assets/img/works/1.jpg')}}" title="Bloodletting Campaign" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{url('/assets/img/works/1.jpg')}}"><img src="{{url('/assets/img/works/1.jpg')}}" class="img-responsive" alt="img"></a></div>
                    <div class="item"><a href="{{url('/assets/img/works/2.jpg')}}" title="Bloodletting Campaign" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{url('/assets/img/works/2.jpg')}}"><img src="{{url('/assets/img/works/2.jpg')}}" class="img-responsive " alt="img"></a></div>
                    <div class="item"><a href="{{url('/assets/img/works/3.jpg')}}" title="Bloodletting Campaign" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{url('/assets/img/works/3.jpg')}}"><img src="{{url('/assets/img/works/3.jpg')}}" class="img-responsive " alt="img"></a></div>
                    <div class="item"><a href="{{url('/assets/img/works/4.jpg')}}" title="Bloodletting Campaign" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{url('/assets/img/works/4.jpg')}}"><img src="{{url('/assets/img/works/4.jpg')}}" class="img-responsive " alt="img"></a></div>
                    <div class="item"><a href="{{url('/assets/img/works/5.jpg')}}" title="Bloodletting Campaign" data-lightbox-gallery="gallery1" data-lightbox-hidpi="{{url('/assets/img/works/5.jpg')}}"><img src="{{url('/assets/img/works/5.jpg')}}" class="img-responsive " alt="img" style=""></a></div>
                </div>
          </div>
                </div>
            </div>
    </div>
<hr>
</section>	
<!-- <div class="wow bounceInUp" data-wow-delay="0.4s">
		<div class ="container">
			<div id ="calendar">
			</div>
		</div>
</div>
<br><br>
</section> -->
<!-- 
	<script>
		$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '2017-06-12',
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2017-05-01',
					color: 'red'
				},
				{
					title: 'Long Event',
					start: '2017-05-07',
					end: '2017-05-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-05-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-05-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2017-05-11',
					end: '2017-05-13'
				},
				{
					title: 'Meeting',
					start: '2017-05-12T10:30:00',
					end: '2017-05-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-05-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-05-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-05-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-05-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-05-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2017-05-28'
				}
			]
		});
		
	});
	</script> -->

@stop
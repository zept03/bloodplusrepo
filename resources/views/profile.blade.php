@extends('layouts.app')

@section('title','BloodPlus')
@section('additional_css')

<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@stop
@section('content')
<div class="container" style="margin-top: 30px;">

    <div class="row">
      <div class="banner-container" style ="background-image: url('{{url('/assets/img/slides/bb3.jpg')}}'">
      </div>
    </div>
    <div class="row">
      <div class="image-profile">
        <img class="img-responsive" src="{{asset('assets/img/man.png')}}"/>
      </div>
    </div>

      <div class="row">
        <div class="container counter-container">         
          <ul class="tiles-counter">
            <li>
              <ul class="counter-details counter-1">
                <li class="counter-header">100</li>
                <li>Blood Donations</li>
              </ul>
            </li>
            <li>
              <ul class="counter-details counter-2">
                <li class="counter-header">292</li>
                <li>Followers</li>
              </ul>
            </li>
            <li>
              <ul class="counter-details counter-3">
                <li class="counter-header">85</li>
                <li>Following</li>
              </ul>
            </li>
          </ul>
          <button class="btn-follow followButton pull-right" rel="6">Follow</button>
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
              <a href="#edit-profile-tab" data-toggle="tab">Edit Profile</a>
            </li>
            <li>
              <a href="#settings-tab" data-toggle="tab">Settings</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="posts-tab">
              <div class="container-fluid">
                @include('layouts.sidebar')
                <div class="col-md-8">
                  <div class="panel panel-default">

                  <div class="panel-body">
                    <ul class="card-header-ul">
                      <h2> Coming soon. Keep updated. </h2>
                    </ul>


                  </div>        
                </div>
                  

                </div>
              </div>
            </div>
            <div class="tab-pane" id="followers-tab">
              <div class="container-fluid">
                @include('layouts.sidebar')
                <div class="col-md-8">
                  <div class="panel panel-default">

                  <div class="panel-body">
                    <ul class="card-header-ul">
                      <h2> Coming soon. Keep updated. </h2>
                    </ul>


                  </div>        
                </div>
                  

                </div>
              </div>
            </div>
            <div class="tab-pane" id="following-tab">
              
            </div>
            <div class="tab-pane" id="edit-profile-tab">
              
            </div>
            <div class="tab-pane" id="settings-tab">
              
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
      if($button.hasClass('following')){
          
          //$.ajax(); Do Unfollow
          
          $button.removeClass('following');
          $button.removeClass('unfollow');
          $button.text('Follow');
      } else {
          
          // $.ajax(); Do Follow
          
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

</script>
@stop
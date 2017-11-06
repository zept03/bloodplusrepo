@extends('adminlte::page')

@section('title', 'Donate')

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

<div class="row">
  <div class="col-xs-12">
    <div class="box box-info  ">
      <div class="box-header">
        <h3 class="box-title">Stage a Blood Bag</h3>
      </div>

      <div class="box-body">
        @if($single)
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/'.$screenedBloodBags->id.'/stage') }}">
        {{$screenedBloodBags->donation->user->name()}}
        {{$screenedBloodBags->donation->user->bloodType}}
        @else
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/stage') }}">
        {{$screenedBloodBags->donation->user->name()}}
        {{$screenedBloodBags->donation->user->bloodType}}
        @endif
        <br>
        Is Blood Reactive?
        <div class="radio">
          <label>
            <input type="radio" class = "reactive" name="reactive" value="true" required>
            Yes
          </label>
          <label>
            <input type="radio" class = "reactive" name="reactive"  value="false">
            No
          </label>
        </div>
        Diagnose
        <div class="radio">
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Hepatitis B" >
            Hepatitis B
          </label>
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Hepatitis C" >
            Hepatitis C
          </label>
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Disease 3" >
            Hepatitis C
          </label>
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Disease 4" >
            Hepatitis C
          </label>
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Disease 5" >
            Hepatitis C
          </label>
          <label>
            <input type="radio" class = "diagnose" name="diagnose" value="Disease 6" >
            Hepatitis C
          </label>

        <!-- if 450q pili siya -->
    
        <!-- endif -->

        {!! csrf_field() !!}

        <center>
        <input type="submit" value="Complete" class="btn btn-danger">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
        </center>
        </form>
              
  	</div>
</div>
</div>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>

    <script> 
      $(document).ready(function() {
        $(".reactive").change(function () {
          if(this.value == 'true')
          {
          $(".diagnose").attr("disabled",false);  
          }
          else
          {
          $(".diagnose").attr("disabled",true);
          }
        });
      });
    </script>
@stop
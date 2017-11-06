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
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/'.$bloodbag->id.'/screen') }}">
        {{$bloodbag->donation->user->name()}}
        {{$bloodbag->donation->updated_at->format('F d Y')}}
        {{$bloodbag->donation->user->bloodType}}
        @else
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/screen') }}">
        {{$bloodbag->donation->user->name()}}
        {{$bloodbag->donation->updated_at->format('F d Y')}}
        {{$bloodbag->donation->user->bloodType}}
        @endif
        <br>
        <!-- if 450d pili siya -->
        1ST BLOOD COMPONENT
        <div class="radio component1">
  
          <label>
            <input type="radio" name="component[1] first-comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="radio" name="component[1] first-comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="radio" name="component[1] first-comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="radio" name="component[1] first-comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[1] first-comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div>
        2ND BLOOD COMPONENT
        <div class="radio component2">
          <label>
            <input type="radio" name="component[2] second-comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div>
        @if($bloodbag->bag_component == '450t' || $bloodbag->bag_component == '450q')
        3RD BLOOD COMPONENT
        <div class="radio component3">
          <label>
            <input type="radio" name="component[3] third_comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div>
        @endif
        @if($bloodbag->bag_component == '450q')
        4TH BLOOD COMPONENT
        <div class="radio component3"> 
          <label>
            <input type="radio" name="component[4] fourth_comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[4] fourth_comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div>
        @endif
        <!-- if 450q pili siya -->
    
        <!-- endif -->
        {!! csrf_field() !!}

        <center>
        <input type="submit" value="Stage" class="btn btn-danger">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
        </center>
        </form>
              
  	</div>
</div>
</div>
@stop
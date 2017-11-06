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
  <div class="col-xs-6 col-md-offset-3">
    <div class="box box-info  ">
      <div class="box-header">
        <center>
          <h3><b>Complete Blood Donation</b></h3>
        </center>
      </div>

      <div class="box-body">
        <form role="form" method="POST" action="{{ url('/admin/donate/'.$donate->id.'/complete') }}">
        <div class = "row">
          <div class ="col-md-4">
          <label class="control-label">Donor Name:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$donate->user->name()}}" readonly/>
          </div>
          <div class ="col-md-2">
          <label class="control-label">Blood Type:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$donate->user->bloodType}}" readonly/>
          </div>
          <div class ="col-md-2">
          <label class="control-label">Gender:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$donate->user->gender}}" readonly/>
          </div>
        </div>
        <br> 
        <label class="control-label">Blood Bag Brand:</label>
        <div class="radio">
          <label style ="margin-left: 1%;margin-right: 1%">
          <input type="radio" name="bag_type" value="karmi" required>
            Karmi
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
            <input type="radio" name="bag_type"  value="radio">
            Terumo
          </label>
        </div>
        <label class="control-label">Blood Bag Component:</label>
        <div class="radio">
          <label style ="margin-left: 1%;margin-right: 1%">
            <input type="radio" name="bag_component" value="450s" required>
            450s
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
            <input type="radio" name="bag_component"  value="450d">
            450d
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
            <input type="radio" name="bag_component"  value="450t">
            450t
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
            <input type="radio" name="bag_component"  value="450q">
            450q
          </label>
        </div>
        <div class ="row">
          <div class ="col-md-2">
          <label class="control-label">Serial Number:</label>
          <input type ="number" class="form-control text-underline" name ="serial-number" placeholder="Input Here" />
          </div>
        </div>
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
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
        <h3 class="box-title">Complete Blood Donation</h3>
      </div>

      <div class="box-body">
        <form role="form" method="POST" action="{{ url('/admin/donate/'.$donate->id.'/complete') }}">
        {{$donate->user->name()}}
        {{$donate->user->bloodType}}
        <br>
        Blood Bag Brand
        <div class="radio">
          <label>
            <input type="radio" name="bag_type" value="karmi" required>
            Karmi
          </label>
          <label>
            <input type="radio" name="bag_type"  value="radio">
            Terumo
          </label>
        </div>
        Blood Bag Component
        <div class="radio">
          <label>
            <input type="radio" name="bag_component" value="450s" required>
            450s
          </label>
          <label>
            <input type="radio" name="bag_component"  value="450d">
            450d
          </label>
          <label>
            <input type="radio" name="bag_component"  value="450t">
            450t
          </label>
          <label>
            <input type="radio" name="bag_component"  value="450q">
            450q
          </label>
        </div>
        <div class ="row">
          <div class ="form-group col-md-4">
            <input type ="number" class ="form-control" name = "serial_number" placeholder="Serial Number" required>
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
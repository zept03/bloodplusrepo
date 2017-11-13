@extends('adminlte::page')

@section('title', 'Donate')

@section('content') 
@if (session('status'))
  <div id = "alertmsg" style="display:none">
    {{ session('status') }}
  </div>

@endif

<div class="row">
  <div class="col-xs-6 col-md-offset-3">
    <div class="box box-info  ">
      <div class="box-header">
        <center>
          <h3 class="box-title"><b>Complete Blood Donation</b></h3>
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
          @if(old('bag_type') == 'karmi')
          <input type="radio" name="bag_type" value="karmi" checked required>
            Karmi
          @else
          <input type="radio" name="bag_type" value="karmi" required>
            Karmi
          @endif
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
          @if(old('bag_type') =='terumo')
            <input type="radio" name="bag_type" checked  value="terumo">
            Terumo
          @else
          <input type="radio" name="bag_type" value="terumo">
            Terumo
          @endif
          </label>
        </div>
        <label class="control-label">Blood Bag Component:</label>
        <div class="radio">
          <label style ="margin-left: 1%;margin-right: 1%">
          @if(old('bag_component') == '450s')
            <input type="radio" name="bag_component" value="450s" checked required>
            450s
          @else
            <input type="radio" name="bag_component" value="450s" required required>
            450s
          @endif
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
          @if(old('bag_component') == '450d')
            <input type="radio" name="bag_component"  checked value="450d">
            450d
          @else
            <input type="radio" name="bag_component"  value="450d">
            450d
          @endif
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
          @if(old('bag_component') == '450t')
            <input type="radio" name="bag_component"  checked value="450t">
            450t
            @else
            <input type="radio" name="bag_component"  value="450t">
            450t
            @endif
          </label>
          <label style ="margin-left: 1%;margin-right: 1%">
          @if(old('bag_component') == '450q')
            <input type="radio" name="bag_component"  checked value="450q">
            450q
            @else
            <input type="radio" name="bag_component"  value="450q">
            450q
            @endif
          </label>
        </div>
        <div class ="row">
          <div class ="col-md-2">
          <label class="control-label">Serial Number:</label>
          <input type ="number" class="form-control text-underline" name ="serial_number" placeholder="Input Here" />
          </div>
        </div>
        @if ($errors->has('serial_number'))
            <span class="help-block">
              <strong>{{ $errors->first('serial_number') }}</strong>
            </span>
          @endif
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
<script>
  $(document).ready(function() {
      var message = document.getElementById('alertmsg').innerHTML;
      if(message != '')
      alert(message);
  });
</script>
@stop
@extends('adminlte::page')

@section('title', 'Request')

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
          <h3 class="box-title"><b>Release Blood Bag</b></h3>
        </center>
      </div>

      <div class="box-body">
        
        <div class = "row">
          <div class ="col-md-4">
          <label class="control-label">Requester:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodRequest->user->name()}}" readonly/>
          </div>
          <div class ="col-md-4">
          <label class="control-label">Patient Name:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodRequest->patient_name}}" readonly/>
          </div>
          <div class ="col-md-4">
          <label class="control-label">Blood Type Requested:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodRequest->details->blood_type.' '.$bloodRequest->details->blood_category}}" readonly/>
          </div>

        </div>
        <br> 
        <div class ="row">
          <div class ="col-md-4">
            <label class="control-label">Blood Bag Serial Number:</label>
            <div class="input-group">
              <select name="diagnose" class="form-control text-underline" id ="diagnose">
                <option value='' disabled hidden selected> Select Serial Number </option>
                @forelse($availBloods as $avail)
                <option value="{{$avail->id}}">{{$avail->screenedBlood->serial_number}}</option>
                @empty
                @endforelse
              </select>
              <div class="input-group-btn">
                  <button type="button" data-count = "{{$bloodRequest->details->units}}" class="btn btn-danger addBtn">Add</button>
              </div>
            </div>
          </div>
        </div>
        <form id ="completeRequestForm" role="form" method="POST" action="{{ url('/admin/request/'.$bloodRequest->id.'/complete') }}">
        {!! csrf_field() !!}
        <br>
        <label class="control-label">Blood Type Requested:</label>
        <ul id ="bloodList">
        </ul>
        <center>
        <input type="submit" id = "submitBrBtn" value="Complete" class="btn btn-danger" disabled>
        <a href ="{{url('admin/request')}}">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
        </a>
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
        var message = document.getElementById('alertmsg').innerHTML;
        if(message != '')
        alert(message);
    });
    </script>

@stop
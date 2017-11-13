@extends('adminlte::page')

@section('title', 'Screen Blood Bag')

@section('content') 
@if (session('status'))
  <div id = "alertmsg" style="display:none">
    {{ session('status') }}
  </div>

@endif

<div class="row">
  <div class="col-xs-12">
    <div class="box box-info  ">
      <div class="box-header">
        <h3 class="box-title">Screen Blood Bags</h3>
      </div>
      <div class="box-body table-responsive">
       <table id = "pending_screening" class="table table-hover ">
          <thead>
            <tr>
              <th><input type ="checkbox" id ="checkAll"></th>
              <th>Serial Number</th>
              <th>Donor</th>
              <th>Blood Type</th>  
              <th>Blood Bag Brand</th>
              <th>Blood Bag Type</th>
              <th>Date Extracted</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendingScreenedBloods as $screenedBlood)
              <tr>
                <td><input type="checkbox" name ="bloodbags" value ="{{$screenedBlood->id}}"></td>
                <td>{{$screenedBlood->serial_number}}</td>
                <td>{{$screenedBlood->donation->user->name()}}</td>
                <td>{{$screenedBlood->donation->user->bloodType}}</td>
                <td>{{$screenedBlood->bag_type}}</td>
                <td>{{$screenedBlood->bag_component}}</td>
                <td>{{$screenedBlood->created_at}}</td>
                <td>
                  <a href ="{{url('admin/donate/'.$screenedBlood->donation->id)}}">
                  <button type="button" value = "{{$screenedBlood->donation->id}}" class="btn-s btn-info"><i class="fa fa-eye"></i></button>
                  </a>
                  @if($screenedBlood->bag_component == '450s')
                  <button type="button" value = "{{$screenedBlood->id}}" class="btn-s btn-success screen450s"><i class="fa fa-check"></i></button>
                  @else
                  <a href ="{{url('admin/bloodbags/'.$screenedBlood->id.'/screen')}}">
                  <button type="button" value = "{{$screenedBlood->donation->id}}" class="btn-s btn-success"><i class="fa fa-check"></i></button>
                  </a>
                  @endif
                </td>
              </tr>
            @empty
            @endforelse
            
          </tbody>
        </table>
      </div>

  	</div>
</div>
</div>
<div class="modal fade modal-danger" id ="acceptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Screen Blood Bag</h4>
      </div>
      <form id ="acceptForm" role="form" method="POST"> 
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker"> 
            {!! csrf_field() !!}
            <input type="hidden" id ="acceptId" name ="component[0]" />
            <div class="form-group">
            <p style ="margin-left:3%" >Do you really want to start screening this blood bag? <br>Press Confirm to start.
            </p>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type ="submit" class="btn btn-danger screenSubmit" data-dismiss="modal">Confirm</button> 
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
      </div>
      </form>
      </div>
    </div>
</div>
@stop

@section('css')
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/css/datepicker3.css')}}" rel ="stylesheet" type ="text/css">
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src ="{{ asset('js/moment.min.js')}}"></script>
    <script src ="{{ asset('js/datetime-moment.js')}}"></script>
    <script> 
      $(document).ready(function() {

      $( "#donateDate" ).datepicker();
      $.fn.dataTable.moment( 'MMMM DD, YYYY' );
      $.fn.dataTable.moment( 'HH:MM AA' );  

      $('#pending_screening').DataTable();
      });

    </script>
    <script>
      $(document).ready(function() {
          var message = document.getElementById('alertmsg').innerHTML;
          if(message != '')
          alert(message);
      });
    </script>

@stop
@extends('adminlte::page')

@section('title', 'Campaign')

@section('content_header')
      <!-- <h1>
      &nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Campaign</li>
      </ol> -->
@stop

@section('content') 
@if (session('status'))
  <div id = "alertmsg" style="display:none">
    {{ session('status') }}
  </div>
@endif
    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div class="box box-info  ">
      <div class="box-header">
        <h3 class="box-title">Campaign</h3>
        <a   href ="{{url('admin/campaign/create')}}" id = "requestId" title="Request for blood" href="javascript:void(0)"><span style="margin-left:10px"><i class="fa fa-plus"></i></span></a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
      <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Ongoing</a></li>
        <li><a href="#tab_2" data-toggle="tab">Upcoming</a></li>
        <li><a href="#tab_3" data-toggle="tab">Done</a></li>
      </ul>
      <div class="tab-content"> 
      <div class="tab-pane active" id = "tab_1">
      <div id = "app" class="box-body table-responsive no-padding">
        <table id = "ongoing_campaigns" class="table table-hover ">
          <thead>
            <th>ID</th>
            <th>Campaign Name</th>
            <th>Address</th>
            <th>Date Start</th>
            <th>Time Start</th>
            <th>Time End</th>
            <th>Actions</th>
          </thead>
          <tbody>
          @foreach($ongoingCampaigns as $campaign)
            @if($campaign->status == 'Ongoing')
              <tr>
                <td>{{$campaign->id}}</td>
                <td>{{$campaign->name}}</td>
                <td>{{$campaign->address['place']}}</td>
                <td>{{$campaign->date_start->format('F jS, Y')}}</td>
                <td>{{$campaign->date_start->format('h:i A')}}</td>
                <td>{{$campaign->date_end->format('h:i A')}}</td>
                <td><button type="button" value = "{{$campaign->id}}" class="btn-xs btn-info decl viewCampaign"><i class="fa fa-eye"></i></button></td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>

        </div>
      </div>
      <div class="tab-pane" id = "tab_2">
      <div id = "app" class="box-body table-responsive no-padding">
        <table id = "pending_campaigns" class="table table-hover ">
          <thead>
            <th>ID</th>
            <th>Campaign Name</th>
            <th>Address</th>
            <th>Date Start</th>
            <th>Time Start</th>
            <th>Time End</th>
            <th>Actions</th>
          </thead>
          <tbody>
          @foreach($pendingCampaigns as $campaign)
            @if($campaign->status == 'Pending')
              <tr>
                <td>{{$campaign->id}}</td>
                <td>{{$campaign->name}}</td>
                <td>{{$campaign->address['place']}}</td>
                <td>{{$campaign->date_start->format('F d Y')}}</td>
                <td>{{$campaign->date_start->format('h:i A')}}</td>
                <td>{{$campaign->date_end->format(' h:i A')}}</td>
                <td><button type="button" value = "{{$campaign->id}}" class="btn-xs btn-info decl viewCampaign"><i class="fa fa-eye"></i></button></td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
            <!-- /.box-footer -->
        </div>
      </div>
      <div class="tab-pane" id = "tab_3">
      <div id = "app" class="box-body table-responsive no-padding">
        <table id = "history_campaigns" class="table table-hover ">
          <thead>
            <th>ID</th>
            <th>Campaign Name</th>
            <th>Address</th>
            <th>Date Start</th>
            <th>Date End</th>
            <th>Actions</th>
          </thead>
          <tbody>
          @foreach($doneCampaigns as $campaign)
            @if($campaign->status == 'Done')
              <tr>
                <td>{{$campaign->id}}</td>
                <td>{{$campaign->name}}</td>
                <td>{{$campaign->address['place']}}</td>
                <td>{{$campaign->date_start->format(' jS \\of F Y H:i A')}}</td>
                <td>{{$campaign->date_end->format(' jS \\of F Y h:i A')}}</td>
                <td><button type="button" value = "{{$campaign->id}}" class="btn-xs btn-info decl viewCampaign"><i class="fa fa-eye"></i></button></td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
            <!-- /.box-footer -->
        </div>
      </div>
  <!-- right col -->
      </div>
      </div>
      </div>
    </div>     
  </div>
</div>
<!-- /.row (main row) --> 
<div class="modal fade modal-danger" id ="createCampaign">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create Campaign</h4>
      </div>
      <div class="modal-body">
        <div id = "view" class="bootstrap-timepicker">
            <div class="form-group">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/campaign/create') }}" enctype="multipart/form-data">  
          {!! csrf_field() !!}
              <label class="control-label">Campaign Name</label>
              <input type="text" name = "campaign_name" class="form-control" placeholder="Name" required >
            </div>
            <div class="form-group">
              <label class="control-label">Campaign Description</label>
              <textarea class="form-control" name="campaign_description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">

              <label class="control-label">Address</label>
              <input id="searchTextField" type="text" class ="form-control" placeholder="Enter a location" autocomplete="on" runat="server" name ="exactcity"/>  
                        <input type="hidden" id="cityLat" name="cityLat" />
                        <input type="hidden" id="cityLng" name="cityLng" />
            </div>
            <div class="form-group">
              <label class="control-label">Picture(*optional)</label>
              <input type="file" name="campaign_avatar" accept="image/*" class="form-control">
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                  <label class="control-label">Date :</label>
                   <input type="text" id = "campaignDate" name="campaign_date" class="form-control" placeholder = "mm/dd/yy" required>
                </div>
                <div style="" class="form-group col-md-4">
                  <label class="control-label">Time Start:</label>
                   <select type="text" class="form-control" name="start_time" placeholder = "mm/dd/yy" required>
                    <option value = "" disabled hidden selected>Start Time</option>
                    <option value="05:00">05:00 AM</option>
                    <option value="06:00">06:00 AM</option>
                    <option value="07:00">07:00 AM</option>
                    <option value="08:00">08:00 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="13:00">01:00 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                    <option value="17:00">05:00 PM</option>
                    <option value="18:00">06:00 PM</option>
                    @if ($errors->has('donatetime'))
                    <span class="help-block">
                    <strong>{{ $errors->first('   ') }}</strong>
                     </span>
                     @endif
                  </select>

                </div>
                  <div class="form-group col-md-4">
                  <label class="control-label">Time End:</label>
                  <select type="text" class="form-control" name="end_time" placeholder = "mm/dd/yy" required>
                    <option value = "" disabled hidden selected>End Time</option>
                    <option value="06:00">06:00 AM</option>
                    <option value="07:00">07:00 AM</option>
                    <option value="08:00">08:00 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="13:00">01:00 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                    <option value="17:00">05:00 PM</option>
                    <option value="18:00">06:00 PM</option>
                    <option value="19:00">07:00 PM</option>
                    <option value="20:00">08:00 PM</option>
                    <option value="21:00">09:00 PM</option>
                    @if ($errors->has('donatetime'))
                    <span class="help-block">
                    <strong>{{ $errors->first('   ') }}</strong>
                     </span>
                     @endif
                  </select>
                  </div>

              </div>
            <!-- /.input group -->
          </div>
                <!-- /.form group -->
        </div>
      <div class="modal-footer" style="margin-top:-1%">
        <input type="submit" class="btn btn-outline" value="Send Request">
        <button type="button" data-dismiss="modal" class="btn btn-outline">Close</button>
        </form>
      </div>
      </div>
    </div>



@stop

@section('css')


    <link rel="stylesheet" type="text/css" href="{{ asset('theme/default.css') }}">
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
    <style>
    .pac-container{
      z-index: 1060 !important;
    }
    .modal{
    z-index: 1050 !important;   
    }
    .modal-backdrop{
    z-index: 1040 !important;        
    } ​
    </style>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src ="{{ asset('js/moment.min.js')}}"></script>
    <script src ="{{ asset('js/datetime-moment.js')}}"></script>
    <script> 

      $(document).ready(function() {
      $.fn.dataTable.moment( 'h:mm A' );
    
      $('#pending_campaigns').DataTable({
        "order": [[ 3, "asc"]]
      });
      $('#ongoing_campaigns').DataTable({
        "order": [[ 3, "asc"]]
      });
      $('#history_campaigns').DataTable({
        "order": [[ 3, "asc"]]
      });
      $( "#campaignDate" ).datepicker();
      });
    </script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAAnRpyGUpGwoIqAlWZgXPaMtrBoogMuWc" type="text/javascript"></script>

<script type="text/javascript">

    $(".viewCampaign").on("click",function () {
      window.location = "{{url('/admin/campaign')}}/"+$(this).val();
    });
    function initialize() {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
           // alert(place.address_components[0].long_name);

        });
    }


    $(".createCampaign").on("click",function () {
      $("#createCampaign").modal();
      initialize();

            var message = document.getElementById('alertmsg').innerHTML;
      if(message != '')
      alert(message);

    });
</script>
@stop

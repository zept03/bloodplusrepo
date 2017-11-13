@extends('adminlte::page')

@section('title', 'Campaign')

@section('content_header')
      <h1>
      &nbsp
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="">Campaign</li>
        <li class="">Create</li>

      </ol>
@stop

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
        <h3 class="box-title">Initiate Campaigns</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form role="form" method="POST" action="{{ url('/admin/campaign/create') }}" enctype="multipart/form-data">
                  {!! csrf_field() !!}
              <label class="control-label">Campaign Name</label>
              <input type="text" name = "campaign_name" class="form-control" placeholder="Name" required >
            <div class="form-group">
              <label class="control-label">Campaign Description</label>
              <textarea class="textarea form-control" name="campaign_description" placeholder="Description" required></textarea>
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
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
              <input type="submit" class ="form-control btn btn-danger" value ="Create">
                </div>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

@stop

@section('css')


    <link rel="stylesheet" type="text/css" href="{{ asset('theme/default.css') }}">
    <link href="{{asset('theme/js/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel ="stylesheet" type ="text/css">
    <link href="{{asset('theme/js/DataTables/media/css/jquery.dataTables.min.css')}}" rel ="stylesheet" type ="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{asset('theme/css/datepicker3.css')}}" rel ="stylesheet" type ="text/css">
    

@stop

@section('js')
    <script type="text/javascript" src="{{asset('theme/js/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('theme/js/dashboard.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAAnRpyGUpGwoIqAlWZgXPaMtrBoogMuWc" type="text/javascript"></script>

<script type="text/javascript">

    $( "#campaignDate" ).datepicker();  
    $(".textarea").wysihtml5({
      "font-styles": true, 
    "emphasis": true, 
    "lists": true,
    "html": false,
    "link": false, 
    "image": false
    });
    $(".viewCampaign").on("click",function () {
      window.location = "{{url('/admin/campaign')}}/"+$(this).val();
    });
    initialize();
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

</script>
@stop

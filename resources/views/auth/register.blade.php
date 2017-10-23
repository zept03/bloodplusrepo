@extends('layouts.master')

@section('title','Register')
@section('content')
@include('layouts.navigation')
<div style="margin-top: 50px;margin-bottom:100px" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                @if ($errors->has('fname'))
                                    <span class="help-block">
                                        <strong> Birthdate invalid. You are not from the future </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="lname" value="{{ old('lname') }}" required autofocus>

                                @if ($errors->has('lname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div style="" class="row  form-group">
                            <label for="name" class="col-md-4 control-label">Middle Initial</label>
                                <div class="col-md-6">
                                <input id="name" type="text" class="forminput" name="mi" value="{{ old('mi') }}" required autofocus>

                                @if ($errors->has('mi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mi') }}</strong>
                                    </span>
                                @endif
                            <label for="name" class="control-label">Blood Type</label>
                                <select class ="forminput" name ="bloodType">
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB+">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                @if ($errors->has('bloodType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bloodType') }}</strong>
                                    </span>
                                @endif  
                                </div>
                        </div>

                        <div style="" class="row  form-group">
                            <label for="email" class="col-md-4 control-label">Gender</label>
                                <div class="col-md-6">
                                <select class ="forminput" name ="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif

                            <label for="name" class="control-label">Birthdate&nbsp&nbsp</label>
                                <input id="dob" type="text" class="forminput" name="dob" value="{{ old('dob') }}" placeholder = "mm/dd/yy" required>

                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                        </div>  
                        </div>

                        <div class="form-group">
                            <label for="contact" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="number" type="number" class="form-control" name="contact" value="{{ old('contact') }}" placeholder ="+63">

                                @if ($errors->has('contact'))
                                    <span class="help-block">
                                        <strong>Invalid contact number</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" value="{{ old('email') }}" name="email" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        <div class ="form-group">
                        <label for="Address" class="col-md-4 control-label">Address</label>
                        <div class="col-md-6">
                        <input id="searchTextField" type="text" class ="form-control" placeholder="Enter a location" autocomplete="on" runat="server" name ="exactcity"/>  
                        <input type="hidden" id="cityLat" name="cityLat" />
                        <input type="hidden" id="cityLng" name="cityLng" /> 
                        </div>
                        </div>
                        <div class="form-group ">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group align-center text-center ">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="form-control btn btn-skin">
                                    Register
                                </button>
                                <a class="btn btn-link" href="{{ url('/login') }}">
                                    Got an account already?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('additional_js')
<script>
$( function() {
$( "#dob" ).datepicker();
});
</script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAAnRpyGUpGwoIqAlWZgXPaMtrBoogMuWc" type="text/javascript"></script>

<script type="text/javascript">
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
    google.maps.event.addDomListener(window, 'load', initialize); 
</script>
@stop
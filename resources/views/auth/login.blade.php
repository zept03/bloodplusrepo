@extends('layouts.master')

@section('title','Login')
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
    <div class="container-fluid" style="padding-right:0px !important;height:100%;background: url(assets/img/bloodplus/pic.jpg);background-size:cover">
        <div class="col-md-8" style ="display: table !important;height:100% !important">
            <div class="text-center align-center" style="display: table-cell !important;
    vertical-align: middle !important;">
            <a href="{{url('/') }}">
            <img src= "{{url('/assets/img/bloodplus/Lg.png')}}" style="width:80%;vertical-align: middle !important">
            </div>
            </a>
        </div>
        <div class="col-md-4" style="display:table; height:100% !important;background:white;">
        <div class="row" style="background: white; padding: 25px;height:100% !important;display: table-cell;
    vertical-align: middle;">
            <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                        <label for="email" class="control-label">E-mail:</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                        <label for="password" class="control-label">Password:</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <br>
                        <div class="form-group align-center text-center">
                        <button type="submit" class="form-control btn btn-skin">
                                Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password </a><br>
                                <a class="btn btn-link" href="{{ url('/register') }}">
                                    Not yet a member?
                                </a>
                        </div>
                        <div class="form-group align-center text-center">
                            <div class="col-md-6 col-md-offset-4">
                            
                            </div>
                        </div>
                    </form>
                    </div>

        </div>
    </div>
@endsection

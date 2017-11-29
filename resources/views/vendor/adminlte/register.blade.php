@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
<div class="container">
    <div class="row">
        <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">        
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>

                     <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-close"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <div style ="margin-left:3%;margin-right:3%">
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Institution</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Address</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Start Date</label>
                                <div class="col-md-12">
                                    <input id="name" type="date" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <ul class="list-inline pull-right">
                            <br>
                                <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <div style ="margin-left:3%;margin-right:3%">
                            <div class="form-group">
                              <label for="name" class="col-md-4 control-label">Blood Categories Available</label>
                              <div class="col-md-12">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Whole Blood
                                </label>
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Packed RBC
                                </label>
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Washed RBC
                                </label>
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Platelets
                                </label>
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Fresh Frozen Plasma
                                </label>
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Cryoprecipitate
                                </label>
                              </div>
                              </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Blood Bag Brands</label>
                            <div class="col-md-12">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Karmi
                                </label>

                                <label>
                                  <input type="checkbox" name ="blood_bag_component">
                                  Terumo
                                </label>

                                <label>
                                  Others(specify)
                                </label>
                              </div>
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Start Date</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                            <br>
                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <div style ="margin-left:3%;margin-right:3%">
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">President</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Vision</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Mission</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                            <br>
                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <div style ="margin-left:3%;margin-right:3%">
                            <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Credentials</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong> Birthdate invalid. You are not from the future </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <ul class="list-inline pull-right">
                            <br>
                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                <li><button type="button" class="btn btn-primary btn-info-full next-step">Complete Registration</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>

@stop

@section('adminlte_js')
    <script src="{{ asset('theme/js/wizard.js') }}"></script>
    @yield('js')
@stop

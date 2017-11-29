@extends('adminlte::bpage')

@section('title', 'Institutions')


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
        <h3 class="box-title">Institutions</h3>
  </div>
      <!-- /.box-header -->
      <div class="box-body">
      </div>
  	</div>
</div>
</div>
@stop
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
        <h3 class="box-title">Screen a Blood Bag</h3>
        </center>
      </div>

      <div class="box-body">
        @if($single)
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/'.$bloodbag->id.'/screen') }}">
        <div class = "row">
          <div class ="col-md-4">
          <label class="control-label">Donor Name:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->user->name()}}" readonly/>
          </div>
          <div class ="col-md-2">
          <label class="control-label">Blood Type:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->user->bloodType}}" readonly/>
          </div>
          <div class ="col-md-3">
          <label class="control-label">Date Extracted:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->updated_at->format('F d Y')}}" readonly/>
          </div>
        </div>
        @else
        <form role="form" method="POST" action="{{ url('/admin/bloodbags/screen') }}">
        <div class = "row">
          <div class ="col-md-4">
          <label class="control-label">Donor Name:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->user->name()}}" readonly/>
          </div>
          <div class ="col-md-2">
          <label class="control-label">Blood Type:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->user->bloodType}}" readonly/>
          </div>
          <div class ="col-md-2">
          <label class="control-label">Date Extracted:</label>
          <input type ="text" class ="form-control text-underline" value ="{{$bloodbag->donation->updated_at->format('F d Y')}}" readonly/>
          </div>
        </div>
        @endif
        <br>
        <!-- if 450d pili siya -->
<!--         <form action="/action_page.php">
          <input type="checkbox" name="vehicle" value="Bike"> I have a bike<br>
          <input type="checkbox" name="vehicle" value="Car" checked> I have a car<br>
          <input type="submit" value="Submit">
        </form> -->
<!-- 
        <select>
          <option value="volvo">Volvo</option>
          <option value="saab">Saab</option>
          <option value="mercedes">Mercedes</option>
          <option value="audi">Audi</option>
        </select> -->


        <div class="row"> 
        <div class="radio component col-md-12">
        <h4>1st Blood Component</h4>
          <select name="component[1]" class="form-control first-comp">
          <option value='' disabled hidden selected> Select Component</option>
            <option value="Packed RBC">Packed RBC</option>
            <option value="Washed RBC">Washed RBC</option>
            <option value="Platelet">Platelet</option><!-- 
            <option value="Cryoprecipitate">Cryoprecipitate</option>
            <option value="resh Frozen Plasma">Fresh Frozen Plasma</option> -->
          </select> 
        </div>



<!--         <div class="radio component1">
  
          <label>
            <input type="combobox z" name="component[1] first-comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="checkbox" name="component[1] first-comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="checkbox" name="component[1] first-comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="checkbox" name="component[1] first-comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="checkbox" name="component[1] first-comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div>
 -->


        <div class="radio component col-md-12">
        <h4>2nd Blood Component</h4>
        <select name="component[2]" class="form-control  second-comp">
            <option value='' disabled hidden selected> Select Component</option>
            <option value="Packed RBC">Packed RBC</option>
            <option value="Washed RBC">Washed RBC</option>
            <option value="Platelet">Platelet</option><!-- 
            <option value="Cryoprecipitate">Cryoprecipitate</option>
            <option value="resh Frozen Plasma">Fresh Frozen Plasma</option> -->
        </select>
        </div>

        <!-- <div class="radio component2">
          <label>
            <input type="radio" name="component[2] second-comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[2] second-comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div> -->

        @if($bloodbag->bag_component == '450t' || $bloodbag->bag_component == '450q')

        <div class="radio component col-md-12">
          <h4>3rd Blood Component</h4>
          <select name="component[3] third-comp" class="form-control">
          <option value='' disabled hidden selected> Select Component</option>
              <option value="Cryoprecipitate">Cryoprecipitate</option>
              <option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option>
          </select> 
          </div>


        <!-- <h4>3rd Blood Component</h4>
        <div class="radio component3">
          <label>
            <input type="radio" name="component[3] third_comp"  value="Packed RBC">
            Packed RBC
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Washed RBC" >
            Washed RBC
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Platelet" >
            Platelet
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[3] third_comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div> -->
        @endif
        @if($bloodbag->bag_component == '450q')


        <div class="radio component col-md-12">
          <h4>4th Blood Component</h4>
          <select name="component[4] third-comp" class="form-control">
          <option value='' disabled hidden selected> Select Component</option>
              <option value="Cryoprecipitate">Cryoprecipitate</option>
              <option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option>
          </select> <br> 
          </div>
        </div>

<!--         4TH BLOOD COMPONENT
        <div class="radio component3"> 
          <label>
            <input type="radio" name="component[4] fourth_comp" value="Cryoprecipitate" >
            Cryoprecipitate
          </label>
          <label>
            <input type="radio" name="component[4] fourth_comp" value="Fresh Frozen Plasma" >
            Fresh Frozen Plasma
          </label>
        </div> -->
        @endif
        <!-- if 450q pili siya -->
    
        <!-- endif -->
        {!! csrf_field() !!}

        <center>
        <input type="submit" value="Stage" class="btn btn-danger">
        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
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
    <script src ="{{ asset('js/moment.min.js')}}"></script>
    <script src ="{{ asset('js/datetime-moment.js')}}"></script>
    <script> 
      $(document).ready(function() {

        $( ".first-comp" ).change(function() {
        if(this.value == 'Packed RBC' || this.value == 'Washed RBC') {
          var option = $('<option></option>').attr("value", "Platelet").text("Platelet");
            $(".second-comp").empty().append(option);
        }
        else if(this.value == 'Platelet'){
          var option = $('<option></option>').attr("value", "Packed RBC").text("Packed RBC");
          var option1 = $('<option></option>').attr("value", "Washed RBC").text("Washed RBC");
            $(".second-comp").empty().append(option, option1);
          }
        else if(this.value == '') 
          $(".second-comp").empty().append(option, option1);
          
      });
        var message = document.getElementById('alertmsg').innerHTML;
          if(message != '')
          alert(message);
      });
    </script>
@stop
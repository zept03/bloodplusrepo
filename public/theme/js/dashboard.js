$(function () {

	$("#calendar").datepicker();

  $(".setRequest").on("click",function() {
    // console.log($(this).val());
    $("#setTimeForm input[name=id]").val($(this).val());
    $("#setTime").modal();
  });

	$(".viewBloodRequest").on("click",function () {
	var first = $(this).val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        method: "post",
        url: "request/view",
        data: {'_token': CSRF_TOKEN,
               'id': first
               },
        success: function(request) {
          //change data of viewmodal
          // console.log(request);
          $("#view input[name=pname]").val(request.patient_name);
          $("#view input[name=diagnose]").val(request.diagnose);
          $("#view input[name=blood_type]").val(request.details.blood_type);
          $("#view input[name=blood_category]").val(request.details.blood_category);
          $("#view input[name=units]").val(request.details.units);
          var updates = request.updates;
          // console.log(updates);
          $("#updates").text("");
          var string = "Waiting for institution to accept the blood request";
          var li = "<li>"+string+"</li>";

          $("#updates").append(li);
          if(updates)
          {
            for(var i = 0;i < updates.length; i++)
            {
              var li = "<li>"+updates[i]+"</li>";
              $("#updates").append(li);
              // console.log(updates[i]);
            }
          }
        },
        error: function() {

            alert('An error occured.');
        }
    	});
	});
  $("#checkAll").change( function() {
    // console.log("lmai");
    if($(this).is(':checked')) {
      $('input[name=bloodbags]').each(function(){ this.checked = true; });
        }
    else
      $('input[name=bloodbags]').each(function(){ this.checked = false; });
  });
  $(".claimRequest").on("click",function () {
    // console.log($(this).val());
    // console.log('abc');
    // alert($(this).val());
    var $csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
          type: 'POST',
          url: '/admin/request/claim',
          data: {
            '_token': $csrf_token,
            'acceptId': $(this).val()
          },
          success: function(response)
          {
            console.log(response);
            alert("You have successfully notified the user");
          },
          error: function(a){
          console.log(a.errorThrown);
          }
      });
    // $("#claimForm input[name=id]").val($(this).val()); 
    // $("#claimModal").modal();
  });
  $(".acceptRequest").on("click",function () {
    // console.log($(this).val());
    $("#acceptForm input[name=id]").val($(this).val());

    // console.log($(this).val());
    // console.log($(this).data("type"));
    var $csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
          type: 'POST',
          url: $(this).data("type")+"/"+$(this).val()+'/bloodbag',
          data: {
            '_token': $csrf_token,
          },
          success: function(response)
          {
            $('#recommended').text('')
            // console.log("12345");
            var i = 0;

            for(i = 0; i < response.updates.length; i++)
            {
              $("#recommended").append(response.updates[i]+"<br>");

            }
            if(response.count == 0)
            {
              $("#accptBtn").attr("disabled",true);
            }
            console.log(response);
          },
          error: function(a){
          // console.log(a.errorThrown);
          }
      });
    $("#acceptModal").modal();
  
  });
  $(".completeRequest").on("click",function () {
    // console.log($(this).val());
    $("#finishForm input[name=id]").val($(this).val());
    $("#doneModal").modal();
  });
  $(".declineRequest").on("click",function () {
    $("#deleteForm input[name=id]").val($(this).val());
    $("#declineModal").modal();
  });
  $(".replybtn").on("click",function () {
    $id = $("#acceptForm input[name=id]").val();
    window.location.href = "/admin/request/"+$id+"/accept";
    // console.log($id);
    // $("#replyForm input[name=id]").val($id);
    // $("#replyForm").submit();
    // $("#replyModal").modal();
  });
  $(".sendTextBlast").on("click", function () {

    if (!$.trim($(".message").val()))
    {
      alert("Please input sms message");
    }
    else {
    var $csrf_token = $('meta[name="csrf-token"]').attr('content');
    var $message = $(".message").val(); 
    var $checkArray =  $('input[name=checkedDonors]:checked');
    var $donorsArray = [];

    $checkArray.each(function(index) {
      $donorsArray[index] = $(this).val();
    });
    if($donorsArray.length == 0)
    alert('Please select donors to send message to');
    else
    {
        // console.log($donorsArray);
      $.ajax({
          type: 'POST',
          url: 'donors/notify',
          data: {
            _token : $csrf_token,
            msg    : $message,
            donorsArray : $donorsArray
          },
          success: function(response)
          {
            alert("Successfully sent messages to these heroes!");
            location.reload();
          },
          error: function(a){
          // console.log(a.errorThrown);
          }
      });
      }
    }
    //get all checked inputs
    //send ajax request
  });

  $("#logout").on('click',function (){
    $("#logout-form").submit();
  })

  $(".something").on('click', function () {
    var id =$(this).val();
    window.location.href = "/admin/request/"+id+"/complete";
  })

  $(".addBtn").on('click', function () {
    // alert('12345');
    var val = $('#diagnose :selected').val();
    var text = $("#diagnose :selected").text();
    var numItems = $('.serial-bags').length;
    var count = $(this).data("count");
    if(count == numItems) 
    {

    }
    else
    {
    if(val != '')
    {

     $option = $("<input type='hidden'>")
        .attr("name", 'serial['+numItems+']')
        .attr("class", 'serial-bags')
        .attr("value", val)

    $("#completeRequestForm").prepend($option)
     $list = $("<li></li>")
        .text("Blood Bag #"+text);
    $("#bloodList").append($list);

    $("#diagnose option:selected").remove();
    $("#diagnose").prop("selectedIndex", 0);
    $("#submitBrBtn").attr("disabled",false);
    var numItems = $('.serial-bags').length;
    var count = $(this).data("count");
      if(count == numItems)
      {
      $(this).attr("disabled",true);   
      }
    }
    else
    {
      alert("Select A Blood Bag Serial number");
    }
    }
  });

  $(".screen450s").on("click",function () {
    // console.log($(this).val());
    $("#acceptForm").attr("action","/admin/bloodbags/"+$(this).val()+"/screen");
    $("#acceptId").val('Whole Blood');

    // console.log($(this).val());
    // console.log($(this).data("type"));
    $("#acceptModal").modal();
  
  });

  $(".screenSubmit").on("click", function () {
    $("#acceptForm").submit();
  });
});
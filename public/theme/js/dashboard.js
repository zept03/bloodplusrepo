$(function () {

	$("#calendar").datepicker();

  $(".setRequest").on("click",function() {
    // console.log($(this).val());
    $("#setTimeForm input[name=id]").val($(this).val());
    $("#setTime").modal();
  });

	$(".viewRequest").on("click",function () {
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
          $("#updates").text("");
          for(var i = 0;i < updates.length; i++)
          {
            var li = "<li>"+updates[i]+"</li>";
            $("#updates").append(li);
            // console.log(updates[i]);
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
      $('input[name=checkedDonors]').each(function(){ this.checked = true; });
        }
    else
      $('input[name=checkedDonors]').each(function(){ this.checked = false; });
  });
  $(".claimRequest").on("click",function () {
    // console.log($(this).val());
    // console.log('abc');
    $("#claimForm input[name=id]").val($(this).val()); 
    $("#claimModal").modal();
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
            for(i = 0; i < response.length; i++)
            {
              $("#recommended").append(response[i]+"<br>");

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
    // console.log($id);
    $("#replyForm input[name=id]").val($id);
    $("#replyForm").submit();
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
});
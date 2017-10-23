$(function () {
$("#logout").on('click', function () {
        $("#logout-form").submit(); 
    })

    $( "#names" ).autocomplete({
      source: "/user/searchajax",
      minLength: 2,
      select: function( event, ui ) {
        // $("#search").submit();
        window.location = '/user/'+ui.item.value;
        $("#names").val(ui.item.label);
        return false;
      }
    });
});



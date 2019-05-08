$(document).ready(function() {
    $('#trips-table').DataTable();
} );


function showDropdown(){
    $("#tablerow_functions").remove();
    let copy = $('<tr><td colspan="100%" class="m-0 p-0"></td></tr>');
    copy.children(":first").html($("#tablerow_template").html());
    copy.attr("id","tablerow_functions");
    copy.find("#tablerow_settings").attr("href","edit-trip-info.php?tripid="+$(event.srcElement.parentElement).attr("id"));
    copy.find("#tablerow_info").attr("href","edit-trip-fish.php?tripid="+$(event.srcElement.parentElement).attr("id"));
    copy.find("#tablerow_money").attr("href","trip-money.php?tripid="+$(event.srcElement.parentElement).attr("id"));
    $(event.srcElement.parentElement).after(copy);
}
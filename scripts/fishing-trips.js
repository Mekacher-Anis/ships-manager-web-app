$(document).ready(function () {
    $('#trips-table').DataTable({
        "order": [[ 0, "desc" ]]
    });
});


function showDropdown(tripid,netGain) {
    $("#tablerow_functions").remove();
    let copy = $('<tr><td colspan="100%" class="m-0 p-0"></td></tr>');
    copy.children(":first").html($("#tablerow_template").html());
    copy.attr("id", "tablerow_functions");
    copy.find("#tablerow_settings")
        .attr("href", "edit-trip-info.php?tripid=" + tripid + "&netgain=" + netGain);
    copy.find("#tablerow_info")
        .attr("href", "edit-trip-fish.php?tripid=" + tripid + "&netgain=" + netGain);
    copy.find("#tablerow_money")
        .attr("href", "trip-money.php?tripid=" + tripid + "&netgain=" + netGain);
    $(event.srcElement.parentElement).after(copy);
}
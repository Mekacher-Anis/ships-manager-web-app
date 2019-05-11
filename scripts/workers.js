$(document).ready(() => {
    window.history.pushState(null, null, location.href);
    window.onpopstate = function () {
        location.href = "category-selection.php";
    }
    $("#workers-table").DataTable();
})
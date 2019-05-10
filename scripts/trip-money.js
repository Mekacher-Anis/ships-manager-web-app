var ownerShare = 0;

$(document).ready(() => {
    ownerShare = parseFloat($("#ownershare").val());
    loadExpensesTable();
})

/*****************************************Expenses****************************************/

function loadExpensesTable(){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            let tableBody = $("#trip-expenses-table").children(":last");

            res.forEach(row => {
                addExpensesTableRow( tableBody,row['Name'], Math.round(row['Value'] * 1000) / 1000, row['ExpensID'] );
            });
        }
    }
    let url = "/includes/retrieve-add-delete-trip-expenses.php?request=retrieve&tripid=" + $("#tripid").val() + "&expensetype=2";
    req.open("GET", url, true);
    req.send();
}

function addExpensesTableRow(tbdoy, name, value, expenseID) {
    let clone = $("#expenses-tablerow-template").clone();
    clone.attr("id", "");
    clone.children().eq(0).text(name);
    clone.children().eq(1).text(value);
    clone.children().eq(2).click(function () {
        deleteExpense(expenseID, this, value);
    });
    clone.show();
    tbdoy.append(clone);
    ownerShare -= value;
    $("#ownerNetGain").text("Mad5oul Safi : " + ownerShare);
}

function addExpense(tripid) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != "fail") {
                let tableBody = $("#trip-expenses-table").children(":last");
                addExpensesTableRow(tableBody,expenseName,value,this.responseText);
            }
        }
    }

    let expenseName = $("#expense-name-input").val();
    let value = $("#expense-value-input").val();
    if (expenseName.length == 0 || value.length == 0)
        return;

    if (!isNaN(value)) {
        let url = "/includes/retrieve-add-delete-trip-expenses.php?request=add&tripid="
        +tripid+"&name="+expenseName+"&value="+value + "&expensetype=2";
        req.open("GET", url, true);
        req.send();
    }
}

function deleteExpense(expenseID, srcElement, value) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText = "ok") {
                $(srcElement).parent().remove();
                ownerShare += value;
                $("#ownerNetGain").text("Mad5oul Safi : " + ownerShare);
            }
        }
    }
    let url = "/includes/retrieve-add-delete-trip-expenses.php?request=delete&expenseid=" + expenseID;
    req.open("GET", url, true);
    req.send();
}

function generatePDF() {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){            
            let tab = window.open(this.responseText);
        }
    };

    req.open("POST","/includes/generate-pdf.php",true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var clone = $("#pdf-content").clone();
    clone.find("#expenses-input").remove();
    req.send("html=" + clone.html());
}
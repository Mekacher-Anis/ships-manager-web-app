
$(document).ready(() => {
    loadWorkersTable();
    loadExpensesTable();
})


/*****************************************Workers****************************************/

function loadWorkersTable(){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            let tableBody = $("#trip-workers-table").children(":last");

            res.forEach(row => {
                addWorkerTableRow(tableBody,row['WorkerID']+ " - " +row['Name'] + " " + row['Lastname'],
                Math.round(row['PartialPayment'] * 1000) / 1000,row['TripID'], row['WorkerID']);
            });
        }
    }
    let url = "/includes/retrieve-add-delete-trip-workers.php?request=retrieve&tripid=" + $("#tripid").val();
    req.open("GET", url, true);
    req.send();
}

function addWorkerTableRow(tbdoy, name, payment, tripid, workerid) {
    let clone = $("#workers-tablerow-template").clone();
    clone.attr("id", "");
    clone.children().eq(0).text(name);
    clone.children().eq(1).text(payment);
    clone.children().eq(2).click(function () {
        deleteWorker(tripid, workerid, this);
    });
    clone.show();
    tbdoy.append(clone);
}

function deleteWorker(tripid, workerid, srcElement) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText = "ok") {
                $(srcElement).parent().remove();
            }
        }
    }
    let url = "/includes/retrieve-add-delete-trip-workers.php?request=delete&tripid=" + tripid + "&workerid=" + workerid;
    req.open("GET", url, true);
    req.send();
}


function addWorker(tripid) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "ok") {
                let tableBody = $("#trip-workers-table").children(":last");
                addWorkerTableRow(tableBody,workerName,
                Math.round(partialPayment * 1000) / 1000,tripid, workerID);
            }
        }
    }

    let workerName = $("#fisher-name-input").val();
    let partialPayment = $("#fisher-partial-payment-input").val();
    if (workerName.length == 0 || partialPayment == 0 || isNaN(partialPayment))
        return;

    let workerID = workerName.slice(" ")[0];
    console.log("Add (" + tripid + "," + workerID + "," + partialPayment + ")");
    if (!isNaN(workerID)) {
        let url = "/includes/retrieve-add-delete-trip-workers.php?request=add&tripid=" +
            tripid + "&workerid=" + workerID + "&payment=" + partialPayment;
        req.open("GET", url, true);
        req.send();
    }else{
        window.location.href="/pages/add-new-worker.php?tripid="+tripid;
    }
}


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
    let url = "/includes/retrieve-add-delete-trip-expenses.php?request=retrieve&tripid=" + $("#tripid").val() + "&expensetype=1";
    req.open("GET", url, true);
    req.send();
}

function addExpensesTableRow(tbdoy, name, value, expenseID) {
    let clone = $("#expenses-tablerow-template").clone();
    clone.attr("id", "");
    clone.children().eq(0).text(name);
    clone.children().eq(1).text(value);
    clone.children().eq(2).click(function () {
        deleteExpense(expenseID, this);
    });
    clone.show();
    tbdoy.append(clone);
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
        +tripid+"&name="+expenseName+"&value="+value + "&expensetype=1";
        req.open("GET", url, true);
        req.send();
    }
}

function deleteExpense(expenseID, srcElement) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText = "ok") {
                $(srcElement).parent().remove();
            }
        }
    }
    let url = "/includes/retrieve-add-delete-trip-expenses.php?request=delete&expenseid=" + expenseID;
    req.open("GET", url, true);
    req.send();
}
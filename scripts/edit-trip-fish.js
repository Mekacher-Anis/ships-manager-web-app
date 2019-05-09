var fishNum = 0;
var freeFishNum = 0;
var income = 0;

$(document).ready(() => {
    income = parseInt($("#trip-info-income").text());
    loadFishTable();
});

function loadFishTable() {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let res = JSON.parse(this.responseText);
            let tableBody = $("#trip-fish-table").children(":last");

            res.forEach(row => {
                addFishTableRow(tableBody, row['Name'], row['Type'], row['Number'], row['TripID'], row['FishID']);
            });
        }
    }
    let url = "/includes/retrieve-add-delete-trip-fish.php?request=retrieve&tripid=" + $("#tripid").val();
    req.open("GET", url, true);
    req.send();
}

function addFishTableRow(tbdoy, name, type, number, tripid, fishid) {
    let clone = $("#fish-tablerow-template").clone();
    clone.attr("id", "");
    clone.children().eq(1).text(name);
    clone.children().eq(2).text(type);
    clone.children().eq(3).text(number);

    clone.children().eq(0).click(function () {
        deleteFish(tripid, fishid, this);
    });

    clone.find('.increment-count').click(function () {
        updateFishNumber(tripid, fishid, this);
    });
    clone.find('.decrement-count').click(function () {
        updateFishNumber(tripid, fishid, this, true);
    });
    clone.show();
    tbdoy.append(clone);

    updateInfo(type,number);
}

function updateInfo(type,number) {
    switch(type){
        case 'Ak7el':
        case 'A7mer':
            fishNum += number;
            $('#trip-info-fish').text(fishNum);
            $("#trip-info-avg").text(Math.round(income / (fishNum + freeFishNum)));
            break;
        case '7out':
            freeFishNum += number;
            $('#trip-info-free-fish').text(freeFishNum);
            $("#trip-info-avg").text(Math.round(income / (fishNum + freeFishNum)));
            break;
    }
}

function addFish(tripid) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "ok") {
                let tableBody = $("#trip-fish-table").children(":last");
                addFishTableRow(tableBody, fishName, type, number, tripid, fishID);
            }
        }
    }

    let fishName = $("#fish-name-input").val();
    let number = $("#fish-number-input").val();
    let type = $("#fish-type-input").val();
    if (fishName.length == 0 || number.length == 0 || type.length == 0 || isNaN(number))
        return;

    let fishID = fishName.split("-")[0];
    let url = "/includes/retrieve-add-delete-trip-fish.php?request=add&tripid=" +
        tripid + "&fishid="+fishID+"&number="+number+"&type="+type;
    req.open("GET", url, true);
    req.send();

}

function deleteFish(tripid, fishid, srcElement) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText = "ok") {
                $(srcElement).parent().remove();
            }
        }
    }
    let url = "/includes/retrieve-add-delete-trip-fish.php?request=delete&tripid=" + tripid + "&fishid=" + fishid;
    req.open("GET", url, true);
    req.send();
}

function updateFishNumber(tripid, fishid, srcElement, decrement) {
    let numberNode = $(srcElement).parent().prev();
    let number = numberNode.text();
    let newNumber = (decrement) ? --number : ++number;
    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText = "ok") {
                numberNode.text(newNumber);
            }
        }
    }
    let url = "/includes/retrieve-add-delete-trip-fish.php?request=update&number="
        +newNumber+"&tripid="+tripid+"&fishid="+fishid;
    req.open("GET", url, true);
    req.send();
}
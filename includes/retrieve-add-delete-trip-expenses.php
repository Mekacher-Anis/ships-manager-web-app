<?php

switch ($_GET['request']) {
    case "retrieve": retrieve(); break;
    case "add": add(); break;
    case "delete": delete(); break;
}

function retrieve(){
    require_once "dbconfig.php";
    $sql = "SELECT `ExpensID`,`Name`,`Value` FROM `TripsExpenses` WHERE (`TripID`=? AND `ExpTypeID`=?);";
    $stmt = $db->prepare($sql);
    $result = array();
    if ($stmt->bind_param("ii", $_GET['tripid'],$_GET['expensetype'])) {
        if ($stmt->execute()) {
            $data = $stmt->get_result();
            while($row = $data->fetch_assoc())
                $result[] = $row;
        }

    }
    echo json_encode($result);
}

function add(){
    require_once "dbconfig.php";
    $sql = "INSERT INTO `TripsExpenses`(`TripID`, `Name`, `Value`, `Date`,`ExpTypeID`) VALUES (?,?,?,?,?);";
    $stmt = $db->prepare($sql);
    $date = date( 'Y-m-d' );
    if ($stmt->bind_param("isdsi", $_GET['tripid'], $_GET['name'], $_GET['value'],$date,$_GET['expensetype']) )
        echo ($stmt->execute()) ? $stmt->insert_id : "fail";
}

function delete(){
    require_once "dbconfig.php";
    $sql = "DELETE FROM `TripsExpenses` WHERE `ExpensID`=?";
    $stmt = $db->prepare($sql);
    if ( $stmt->bind_param("i", $_GET['expenseid']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}

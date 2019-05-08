<?php

switch ($_GET['request']) {
    case "retrieve": retrieve(); break;
    case "add": add(); break;
    case "delete": delete(); break;
}

function retrieve(){
    require_once "dbconfig.php";
    $sql = "SELECT `TripID`,`TripsWorkers`.`WorkerID`,`Name`,`Lastname`,`PartialPayment` FROM `TripsWorkers`
    INNER JOIN Workers ON TripsWorkers.WorkerID = Workers.WorkerID
    WHERE `TripID`=?";
    $stmt = $db->prepare($sql);
    $result = array();
    if ($stmt->bind_param("i", $_GET['tripid'])) {
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
    $sql = "INSERT INTO `TripsWorkers`(`TripID`, `WorkerID`, `PartialPayment`) VALUES (?,?,?);";
    $stmt = $db->prepare($sql);
    if ($stmt->bind_param("iid", $_GET['tripid'], $_GET['workerid'], $_GET['payment']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}

function delete(){
    require_once "dbconfig.php";
    $sql = "DELETE FROM `TripsWorkers` WHERE `TripID`=? AND `WorkerID`=?";
    $stmt = $db->prepare($sql);
    if ( $stmt->bind_param("ii", $_GET['tripid'], $_GET['workerid']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}

<?php

switch ($_GET['request']) {
    case "retrieve": retrieve(); break;
    case "add": add(); break;
    case "delete": delete(); break;
    case "update": updateFish(); break;
}

function retrieve(){
    require_once "dbconfig.php";
    $db->set_charset("utf8");
    $sql = "SELECT * FROM `TripsFish`
    INNER JOIN FishTypes ON TripsFish.FishID = FishTypes.FishID
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
    $sql = "INSERT INTO `TripsFish`(`TripID`, `FishID`, `Number`, `Type`) VALUES (?,?,?,?);";
    $stmt = $db->prepare($sql);
    if ($stmt->bind_param("iids", $_GET['tripid'], $_GET['fishid'], $_GET['number'],$_GET['type']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}

function delete(){
    require_once "dbconfig.php";
    $sql = "DELETE FROM `TripsFish` WHERE (`TripID`=? AND `FishID`=?)";
    $stmt = $db->prepare($sql);
    if ( $stmt->bind_param("ii", $_GET['tripid'],$_GET['fishid']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}

function updateFish(){
    require_once "dbconfig.php";
    $sql = "UPDATE `TripsFish` SET `Number`=? WHERE (`TripID`=? AND `FishID`=?)";
    $stmt = $db->prepare($sql);
    if ( $stmt->bind_param("iii",$_GET['number'], $_GET['tripid'],$_GET['fishid']) )
        echo ($stmt->execute()) ? "ok" : "fail";
}
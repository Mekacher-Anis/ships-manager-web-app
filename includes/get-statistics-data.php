<?php
session_start();
switch ($_GET['data']) {
    case 'expenses':
        getExpensesData();
        break;
    case 'gain':
        getGainData();
        break;
    default:
        die;
}

function getExpensesData(){
    require_once "dbconfig.php";
    switch ($_GET['period']) {
        case '1':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29));
            break;
        case '6':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29 * 6));
            break;
        case '12':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29 * 12));
            break;
    }
    $sql = "SELECT TripsExpenses.Name, SUM(TripsExpenses.Value) AS `Value`
    FROM `Trips`
    INNER JOIN TripsExpenses ON Trips.TripID = TripsExpenses.TripID
    WHERE (ShipID=" . $_SESSION['shipid'] . " AND TripsExpenses.ExpTypeID=1 AND `Date` > '".$date."')
    GROUP BY TripsExpenses.Name";
    $data = array();
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
}

function getGainData(){
    require_once "dbconfig.php";
    switch ($_GET['period']) {
        case '1':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29));
            break;
        case '6':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29 * 6));
            break;
        case '12':
            $date = date("Y-m-d",time() - (60 * 60 * 24 * 29 * 12));
            break;
    }
    $sql = "SELECT `Arrival`,`Gain` FROM `Trips` WHERE (`ShipID`=".$_SESSION['shipid']." AND `Departure` > '".$date."') ORDER BY `Arrival`";
    $data = array();
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
}
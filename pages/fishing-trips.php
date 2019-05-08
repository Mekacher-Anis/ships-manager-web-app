<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }

    if (!isset($_SESSION['shipid']))
        header("Location: ship-selection.php");

    require "../includes/dbconfig.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- <script type="text/javascript" src="http://livejs.com/live.js"></script> -->
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Ships Manager</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarColor01" style="">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link"><?php echo $_SESSION['username'];?></a>
                </li>
            </ul>
            <form class="form-inline" method="GET" action=<?php echo $_SERVER['PHP_SELF'];?>>
                <button class="btn btn-secondary" name="logout" value="logout" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container main-cont">
        <div class="jumbotron my-4 overflow-auto">

            <table class="table table-striped my-4" id="trips-table">
                <thead class="thead-dark">
                    <tr>
                        <th>5rouj</th>
                        <th>D5oul</th>
                        <th>Mad5oul</th>
                        <th class="d-none d-md-table-cell">7rouguat</th>
                        <th class="d-none d-md-table-cell">Reba7 Safi</th>
                        <th class="d-none d-md-table-cell">Swaya3</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT `Trips`.`TripID`,`Departure`,`Arrival`,`Gain`,SUM(Value) AS Expenses FROM `Trips`
                    LEFT JOIN TripsExpenses ON Trips.TripID = TripsExpenses.TripID
                    WHERE `ShipID`=".$_SESSION['shipid']."
                    GROUP BY `TripID`";

                    if($result = $db->query($sql)){
                        while($row = $result->fetch_assoc()){
                            if($row['Arrival'])
                                $secondsDiff = strtotime($row['Arrival']) - strtotime($row['Departure']);
                            else
                                $secondsDiff = time() - strtotime($row['Departure']);
                            $numDays = round($secondsDiff / (60 * 60)) + 24;

                ?>
                    <tr id="<?php echo $row['TripID'];?>" onclick="showDropdown()">
                        <td><?php echo $row['Departure'] ?></td>
                        <td><?php echo ($row['Arrival']) ? $row['Arrival'] : "-" ?></td>
                        <td><?php echo ($row['Gain']) ? round($row['Gain'],3) : "-" ?></td>
                        <td class="d-none d-md-table-cell"><?php echo ($row['Expenses']) ? round($row['Expenses'],3) : "-" ?>
                        </td>
                        <td class="d-none d-md-table-cell"><?php echo ($row['Gain'] - $row['Expenses']) ? $row['Gain'] - $row['Expenses'] : "-"; ?></td>
                        <td class="d-none d-md-table-cell"><?php echo $numDays ?></td>
                    </tr>
                    <?php

                        }
                    }
                ?>
                </tbody>
            </table>

            <a href="edit-trip-info.php?tripid=0" class="btn btn-lg btn-success my-4 float-right">add</a>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <div id="tablerow_template" class="d-none">
        <tr>
            <td colspan="100%" class="m-0 p-0">
                <a id="tablerow_settings" class="p-1 rounded-bottom float-right" style="background-color: #4BFFA8;">
                    <img src="../images/icons/settings.svg" style="height:40px;width:40px;">
                </a>
                <a id="tablerow_info" class="p-1 bg-warning rounded-bottom float-right">
                    <img src="../images/icons/info.svg" style="height:40px;width:40px;">
                </a>
                <a id="tablerow_money" class="p-1 rounded-bottom float-right" style="background-color: #FF5A6E;">
                    <img src="../images/icons/money.svg" style="height:40px;width:40px;">
                </a>
            </td>
        </tr>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="../scripts/fishing-trips.js"></script>

</body>

</html>
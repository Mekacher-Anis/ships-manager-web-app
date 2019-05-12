<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }

    $fisherShare = $_GET['netgain'] * 0.48;
    $tripID = filter_var($_GET['tripid'],FILTER_SANITIZE_NUMBER_INT);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ships Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="category-selection.php">Ships Manager</a>
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
        <div class="jumbotron text-center my-5 p-1" style="overflow:auto;">
            <div id="pdf-content">
            <h4 class="my-3 text-info">Manab L'ba7ara (48%) : <?php echo round($fisherShare,3);?></h4>
            <table class="table table-striped table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Esem</th>
                        <th>Bay</th>
                        <th>5lass</th>
                        <th>Masrouf</th>
                        <th>Ba9i</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once "../includes/dbconfig.php";
                        $sql = "SELECT SUM(`Share`) AS `Sum` FROM `TripsWorkers`
                        INNER JOIN Workers ON TripsWorkers.WorkerID = Workers.WorkerID
                        WHERE `TripID`=" . $tripID;
                        if($result = $db->query($sql)){
                            $shareSum = $result->fetch_assoc()['Sum'];
                            $shareValue = $fisherShare / $shareSum;
                        }
                        $sql = "SELECT `Name`,`Lastname`,`Share`,`PartialPayment` FROM `TripsWorkers`
                        INNER JOIN Workers ON TripsWorkers.WorkerID = Workers.WorkerID
                        WHERE `TripID`=" . $tripID;
                        if ($result = $db->query($sql)) {
                                while($row = $result->fetch_assoc()){
                                    $totalPayment = $shareValue * $row['Share'];
                    ?>
                    <tr>
                        <td><?php echo $row['Name'] . " " . $row['Lastname']; ?></td>
                        <td><?php echo $row['Share']; ?></td>
                        <td><?php echo round($totalPayment,3); ?></td>
                        <td><?php echo round($row['PartialPayment'],3); ?></td>
                        <td><?php echo round($totalPayment - $row['PartialPayment'],3); ?></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <hr>
            <h4 class="my-3 text-info">Manab L'moujahez (52%) : <?php echo round($_GET['netgain'] - $fisherShare,3);?>
            </h4>
            <input type="hidden" name="ownershare" id="ownershare" value="<?php echo round($_GET['netgain'] - $fisherShare,3);?>">
            <div class="expenses-edit-container mt-3 p-2 rounded w-75 mx-auto" style="background-color:#d6d6d6;">
                <h3 class="text-center text-warning">7rouguat L'Moujahez</h3>
                <div class="form-inline d-flex justify-content-center" id="expenses-input">
                    <label for="fisher-name-input">Esem</label>
                    <input type="text" name="expense-name" id="expense-name-input" class="form-control mx-2">
                    <label for="fisher-name-input" class="mt-2 mt-md-0">9ima</label>
                    <input type="text" name="expense-value" id="expense-value-input" class="form-control mx-2">
                    <input type="hidden" id="tripid" name="tripid" value="<?php echo $_GET['tripid'];?>">
                    <button class="btn btn-success mt-2 mt-md-0" onclick="addExpense(<?php echo $_GET['tripid']; ?>)">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <table class="table table-striped mt-2" id="trip-expenses-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Esem</th>
                            <th>9ima</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="expenses-tablerow-template" style="display:none;">
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <button class="btn btn-success">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h4 id="ownerNetGain" class="my-3 text-info">Mad5oul Safi :</h4>
            </div>

            <button class="btn btn-sm btn-primary" onclick="generatePDF()">pdf</button>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="../scripts/trip-money.js"></script>
</body>

</html>
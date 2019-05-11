<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
}

if (isset($_GET["logout"])) {
    session_destroy();
    header('Location: ../index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../includes/dbconfig.php";

    //add new ship, else edit existing onw
    if ($_POST['tripid'] == 0) {
        $sql = "INSERT INTO `Trips`(`ShipID`, `Departure`, `Arrival`, `Gain`) VALUES (?,?,?,?);";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("issd", $_SESSION['shipid'], $_POST['departure'], $_POST['arrival'],$_POST['gain'])) {
            $stmt->execute();
            header("Location: fishing-trips.php");
        }
    } elseif ($_POST['tripid'] > 0 AND !isset($_POST['remove-trip']) ) {
        $sql = "UPDATE `Trips` SET `Departure`=?,`Arrival`=?,`Gain`=? WHERE `TripID`=?";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("ssii", $_POST['departure'], $_POST['arrival'],$_POST['gain'],$_POST['tripid'])) {
            $stmt->execute();
            header("Location: fishing-trips.php");
        }
    } elseif ($_POST['tripid'] > 0 AND isset($_POST['remove-trip']) ) {
        $sql = "DELETE FROM `Trips` WHERE `TripID`=?;";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("i",$_POST['tripid'])) {
            $stmt->execute();
            header("Location: fishing-trips.php");
        }
    }
}

if (!isset($_GET['tripid'])) {
    header("Location: fishing-trips.php");
}

//load
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">

    <!-- <script type="text/javascript" src="http://livejs.com/live.js"></script> -->
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
                    <a class="nav-link"><?php echo $_SESSION['username']; ?></a>
                </li>
            </ul>
            <form class="form-inline" method="GET" action=<?php echo $_SERVER['PHP_SELF']; ?>>
                <button class="btn btn-secondary" name="logout" value="logout" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container main-cont">
        <div class="jumbotron my-5 mx-auto col-md-10" style="overflow:auto;">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                    require_once "../includes/dbconfig.php";
                    if($_GET['tripid'] > 0){
                    $sql = "SELECT `Departure`, `Arrival`, `Gain` FROM `Trips` WHERE `TripID`=?;";
                    $stmt = $db->prepare($sql);
                    if ( $stmt->bind_param("i", $_GET['tripid'] )) {
                        if($stmt->execute())
                            $row = ($stmt->get_result())->fetch_assoc();
                    }
                    }
                ?>
                <div class="form-group">
                    <label for="name">5rouj</label>
                    <input type="date" class="form-control" name="departure" value="<?php echo $row['Departure'];?>" 
                    id="departure-input" required>
                </div>
                <div class="form-group">
                    <label for="name">D5oul</label>
                    <input type="date" class="form-control" name="arrival" value="<?php echo $row['Arrival'];?>"
                    id="arrival-input" required>
                </div>
                <div class="form-group">
                    <label for="name">Mad5oul</label>
                    <input type="text" class="form-control" name="gain" value="<?php echo round($row['Gain'],3);?>"
                    id="gain-input" required>
                </div>
                <input type="hidden" id="tripid" name="tripid" value="<?php echo $_GET['tripid'];?>" >
                <button class="btn btn-danger" name="remove-trip" value="remove" >remove</button>
                <button type="submit"
                    class="btn btn-success float-right"><?php echo ($_GET['tripid'] == 0) ? "add" : "save"; ?></button>
            </form>

            <?php if($_GET['tripid'] != 0){?>
            <div class="employee-edit-container mt-3 p-2 rounded" style="background-color:#d6d6d6;">
                <h3 class="text-center text-info">Ba7ara</h3>
                <div class="form-inline d-flex justify-content-center">
                    <label for="fisher-name-input">Esem</label>
                    <input list="workers-list" name="fisher-name" id="fisher-name-input" class="form-control mx-2" autocomplete="off" required>
                    <datalist id="workers-list">
                    <?php
                        require_once "../includes/dbconfig.php";
                        $sql = "SELECT `WorkerID`,`Name`,`Lastname` FROM `Workers` WHERE `ShipID`=".$_SESSION['shipid'];
                        $result = $db->query($sql);
                        while($row = $result->fetch_assoc())
                            echo '<option value="'.$row['WorkerID']." - ".$row['Name']." ".$row['Lastname'].'">';
                    ?>
                    </datalist>
                    <label for="fisher-name-input" class="mt-2 mt-md-0">Masrouf</label>
                    <input type="text" name="fisher-partial-payment" id="fisher-partial-payment-input" class="form-control mx-2" autocomplete="off" required>
                    <button class="btn btn-success mt-2 mt-md-0" onclick="addWorker(<?php echo $_GET['tripid']; ?>)">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <table class="table table-striped mt-2" id="trip-workers-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Esem</th>
                            <th>Masrouf</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="workers-tablerow-template" style="display:none;">
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
            <div class="expenses-edit-container mt-3 p-2 rounded" style="background-color:#d6d6d6;">
                <h3 class="text-center text-info">7rouguat</h3>
                <div class="form-inline d-flex justify-content-center">
                    <label for="fisher-name-input">Esem</label>
                    <input type="text" name="expense-name" id="expense-name-input" class="form-control mx-2">
                    <label for="fisher-name-input" class="mt-2 mt-md-0">9ima</label>
                    <input type="text" name="expense-value" id="expense-value-input" class="form-control mx-2">
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
            <?php }?>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="../scripts/edit-trip-info.js"></script>
</body>

</html>
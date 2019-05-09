<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }
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
        <div class="jumbotron  my-5 mx-auto mt-3 p-1 col-md-10" style="overflow:auto;">
            <h3 class="text-center text-info">7out</h3>
            <div class="form-inline d-flex justify-content-center mb-6">
                <div class="form-group">
                    <label for="fish-name-input">Esem</label>
                    <input list="fish-list" name="fish-name" id="fish-name-input" class="form-control mx-2"
                        autocomplete="off" required>
                    <datalist id="fish-list">
                        <?php
                        require_once "../includes/dbconfig.php";
                        $db->set_charset("utf8");
                        $sql = "SELECT * FROM `FishTypes`;";
                        $result = $db->query($sql);
                        while($row = $result->fetch_assoc())
                            echo '<option value="'.$row['FishID']." - ".$row['Name'].'">';
                            ?>
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="fish-number-input" class="mt-2 mt-md-0">3dad</label>
                    <input type="text" name="fish-number" id="fish-number-input" class="form-control mx-2"
                        autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="fish-number-input" class="mt-2 mt-md-0">Naw3iya</label>
                    <input list="fish-types-list" name="fish-type" id="fish-type-input" class="form-control mx-2"
                        autocomplete="off" required>
                    <datalist id="fish-types-list">
                        <option value="Ak7el"></option>
                        <option value="A7mer"></option>
                        <option value="7out"></option>
                    </datalist>
                </div>
                <input type="hidden" name="tripid" id="tripid" value="<?php echo $_GET['tripid']; ?>">
                <button class="btn btn-success mt-2 mt-md-0" onclick="addFish(<?php echo $_GET['tripid']; ?>)">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <table class="table table-striped mt-2" id="trip-fish-table" style="background-color : #ffff75;">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Esem</th>
                        <th>Naw3iya</th>
                        <th>3dad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="fish-tablerow-template" style="display:none;">
                        <td>
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td class="text-center mx-0 p-0">
                            <button class="btn btn-sm btn-info my-1 increment-count">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-primary my-1 decrement-count">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php
                require_once "../includes/dbconfig.php";
                $sql = "SELECT `Gain` FROM `Trips` WHERE `TripID`=?;";
                $stmt = $db->prepare($sql);
                if ( $stmt->bind_param("i", $_GET['tripid'] )) {
                    if($stmt->execute())
                        $row = ($stmt->get_result())->fetch_assoc();
                }
            ?>

            <div class="jumbotron m-3 p-3" style="background-color: #9bff9e;">
                <h4 class="d-inline mx-3">Tirarat : </h4><h4 class="d-inline" id="trip-info-fish">0</h4><br>
                <h4 class="d-inline mx-3">7out : </h4><h4 class="d-inline" id="trip-info-free-fish">0</h4><br>
                <h4 class="d-inline mx-3">Mad5oul : </h4><h4 class="d-inline" id="trip-info-income"><?php echo round($row['Gain'],3); ?></h4><br>
                <h4 class="d-inline mx-3">Dinar/Tirar : </h4><h4 class="d-inline" id="trip-info-avg">0</h4><br>
            </div>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="../scripts/edit-trip-fish.js"></script>

</body>

</html>
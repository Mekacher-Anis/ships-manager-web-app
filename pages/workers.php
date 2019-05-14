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
    <title>Ships Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

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
                    <a class="nav-link"><?php echo $_SESSION['username'];?></a>
                </li>
            </ul>
            <form class="form-inline" method="GET" action=<?php echo $_SERVER['PHP_SELF'];?>>
                <button class="btn btn-secondary" name="logout" value="logout" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container main-cont">
        <div class="jumbotron text-center my-5 overflow-auto">
            <table class="table table-striped" id="workers-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Esem</th>
                        <th>Bay</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once "../includes/dbconfig.php";
                        $sql = "SELECT * FROM `Workers` WHERE `ShipID`=" . $_SESSION['shipid'];
                        if($result = $db->query($sql)){
                            while($row = $result->fetch_assoc()){
                    ?>
                    <tr onclick="window.location.href = 'edit-worker.php?<?php echo 'workerid='.$row['WorkerID'].'&back='.$_SERVER['REQUEST_URI']?>'">
                        <td><?php echo $row['Name']." ".$row['Lastname']?></td>
                        <td><?php echo $row['Share']?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
            <a href="edit-worker.php?workerid=0&back=<?php echo $_SERVER['REQUEST_URI']?>" class="btn btn-success float-right">add</a>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="../scripts/workers.js"></script>

</body>

</html>
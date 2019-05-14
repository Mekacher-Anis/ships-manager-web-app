<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }

    if ( !isset($_GET['shipid']) AND (!isset($_SESSION['shipid'])) ) {
        header("Location: ship-selection.php");
    }elseif(!isset($_SESSION['shipid']))
        $_SESSION['shipid'] = $_GET['shipid'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ships Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

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
        <div class="jumbotron text-center my-5" style="overflow:auto;">
            <div class="row">
                <a href="fishing-trips.php" class="btn btn-primary col-8 col-sm-5 col-md-4 col-lg-3 mx-auto my-2">
                    <img src="../images/icons/fishing.svg" class="rounded img-fluid" style="height:150px;width:150px;">
                    <h4 class="my-2">Ser7at</h4>
                </a>
                <a href="workers.php" class="btn btn-primary col-8 col-sm-5 col-md-4 col-lg-3 mx-auto my-2">
                    <img src="../images/icons/fisherman.svg" class="rounded img-fluid"
                        style="height:150px;width:150px;">
                    <h4 class="my-2">Ba7ara</h4>
                </a>
            </div>
            <div class="row">
                <a href="statistics.php" class="btn btn-primary col-8 col-sm-5 col-md-4 col-lg-3 mx-auto my-2">
                    <img src="../images/icons/static-bars.svg" class="rounded img-fluid"
                        style="height:150px;width:150px;">
                    <h4 class="my-2">7sabat</h4>
                </a>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        window.history.pushState(null,null,location.href);
        window.onpopstate = function() {
            location.href = "ship-selection.php";
        }
    </script>

</body>

</html>
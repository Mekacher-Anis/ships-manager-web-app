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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

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
            <h1 class="display-3">Flayek</h1>
            <p class="lead">Please select a ship</p>
            <hr class="my-2">

            <?php
                require "../includes/dbconfig.php";
                $sql = "SELECT `ShipID`,`Name`,`ImageLocation` FROM `Ships` WHERE `UID`=".$_SESSION['userid'].";";
                if($results = $db->query($sql)){
                    if($results->num_rows > 0){
                        while($row = $results->fetch_assoc()){
            ?>
            <div class="row">
                <div class="d-flex col-md-6 mx-auto my-2">
                    <a href="category-selection.php?shipid=<?php echo $row['ShipID'];?>" class="btn btn-primary mx-0 w-100" style="border-radius: 5px 0 0 5px;">
                        <img src="http://<?php echo $_SERVER['HTTP_HOST'] . $row['ImageLocation']; ?>" class="border border-white" style="border-radius: 6px;height:100px;width:100px;" alt="img">
                        <h5 class="d-lg-inline mx-4" style="color: white;"><?php echo $row['Name'];?></h5>
                    </a>
                    <a class="btn btn-info mx-0 d-flex" href="edit-ship-info.php?shipid=<?php echo htmlspecialchars($row['ShipID'] . '&shipname=' .$row['Name'].'&shipimg='. $row['ImageLocation']); ?>" style="border-radius: 0 5px 5px 0;" role="button">
                        <i class="fas fa-cog fa-lg my-auto"></i>
                    </a>
                </div>
            </div>
            <?php
                        }
                    }else{
                        echo "<h4>No Ships. Please add a ship.</h4>";
                    }
                } 
            ?>
            <a href="edit-ship-info.php?shipid=0" class="btn btn-lg btn-success my-4 float-right">add</a>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        window.history.pushState(null,null,location.href);
        window.onpopstate = function() {
            window.history.pushState(null,null,location.href);
        }
    </script>

</body>

</html>
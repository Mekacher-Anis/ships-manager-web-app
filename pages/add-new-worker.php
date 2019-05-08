<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once "../includes/dbconfig.php";
        $sql = "INSERT INTO `Workers`(`ShipID`, `Name`, `Lastname`, `Share`) VALUES (?,?,?,?);";
        $stmt = $db->prepare($sql);
        if($stmt->bind_param("issd",$_SESSION['shipid'],$_POST['name'],$_POST['lastname'],$_POST['share'])){
            if($stmt->execute())
                header('Location: edit-trip-info.php?tripid='.$_POST['tripid']);
        }
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
        <div class="jumbotron text-center mx-auto my-5 pt-0 col-md-8 col-lg-6" style="overflow:auto;">
            <h4 class="my-3 text-info">Ba7ar</h4>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form">
                <div class="form-group">
                    <label for="name-input-field">Esem</label>
                    <input type="text" name="name" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="name-input-field">La9ab</label>
                    <input type="text" name="lastname" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="name-input-field">Bay</label>
                    <input type="text" name="share" id="share-input" class="form-control" autocomplete="off" required>
                </div>
                <input type="hidden" name="tripid" value="<?php echo $_GET['tripid'] ?>">
                <input type="submit" id="new-worker-submit-button" class="btn btn-lg btn-success float-right my-2"
                    value="add" disabled>
            </form>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(() => {
            $("#share-input").change(function (event) {
                if (!isNaN(event.target.value))
                    $("#new-worker-submit-button").removeAttr("disabled");
                else
                    $("#new-worker-submit-button").attr("disabled", "");
            });
        })
    </script>

</body>

</html>
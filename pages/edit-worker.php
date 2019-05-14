<?php
    session_start();
    if(!isset($_SESSION['username']))
        header('Location: ../index.php');

    if(isset($_GET["logout"])){
            session_destroy();
            header('Location: ../index.php');
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../includes/dbconfig.php";
    if(isset($_POST['remove'])){
        $workerid = filter_var($_POST['workerid'],FILTER_SANITIZE_NUMBER_INT);
        $sql = "DELETE FROM `Workers` WHERE `WorkerID`=" . $workerid;
        if($db->query($sql)){
            header("Location: .." . $_POST['returnAdr']);
        }
    }
    if ($_POST['workerid'] == 0) {
        $sql = "INSERT INTO `Workers`(`ShipID`, `Name`, `Lastname`, `Share`) VALUES (?,?,?,?);";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("issd", $_SESSION['shipid'], $_POST['name'], $_POST['lastname'], $_POST['share'])) {
            if ($stmt->execute()) {
                header("Location: .." . $_POST['returnAdr']);
            }

        }
    }elseif($_POST['workerid'] > 0){
        $sql = "UPDATE `Workers` SET `Name`=?,`Lastname`=?,`Share`=? WHERE `WorkerID`=?";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("ssdi",$_POST['name'], $_POST['lastname'], $_POST['share'],$_POST['workerid'])) {
            if ($stmt->execute()) {
                header("Location: .." . $_POST['returnAdr']);
            }

        }
    }
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
        <div class="jumbotron text-center mx-auto my-5 pt-0 col-md-8 col-lg-6" style="overflow:auto;">
            <h4 class="my-3 text-info">Ba7ar</h4>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form">
                <?php
                    if($_GET['workerid'] != 0){
                    require_once "../includes/dbconfig.php";
                    $workerid = filter_var($_GET['workerid'],FILTER_SANITIZE_NUMBER_INT);
                    $sql = "SELECT * FROM `Workers` WHERE `WorkerID`=" . $workerid;
                    if($result = $db->query($sql)){
                        $row = $result->fetch_assoc();
                    }}
                ?>
                <div class="form-group">
                    <label for="name-input-field">Esem</label>
                    <input type="text" name="name" value="<?php echo $row['Name']; ?>" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="name-input-field">La9ab</label>
                    <input type="text" name="lastname" value="<?php echo $row['Lastname'];?>" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="name-input-field">Bay</label>
                    <input type="text" name="share" value="<?php echo $row['Share'];?>" id="share-input" class="form-control" autocomplete="off" required>
                </div>
                <input type="hidden" name="returnAdr" value="<?php echo $_GET['back'] ?>">
                <input type="hidden" name="workerid" value="<?php echo $_GET['workerid'];?>">
                <input type="submit" id="new-worker-submit-button" class="btn btn-lg btn-success float-right my-2"
                    value="<?php echo ($_GET['workerid'] == 0) ? "add" : "save"; ?>" disabled>
                <?php if($_GET['workerid'] != 0){?>
                <input type="submit" class="btn btn-lg btn-danger float-left my-2" name="remove" value="remove">
                <?php }?>
            </form>
        </div>
    </div>

    <?php include "footer.php" ?>

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
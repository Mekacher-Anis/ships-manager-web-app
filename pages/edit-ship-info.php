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
    require "../includes/utilities.php";
    require "../includes/dbconfig.php";

    //add new ship, else edit existing onw
    if ($_POST['shipid'] == 0) {
        $target_file = getTargetFileName($_FILES["shipimg"]["name"]);
        if (uploadImage('shipimg', $target_file, "") !== true) {
            $target_file = "/uploads/cruise.png";
        }

        $sql = "INSERT INTO `Ships`(`UID`, `Name`, `ImageLocation`) VALUES (?,?,?);";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("iss", $_SESSION['userid'], $_POST['shipname'], $target_file)) {
            $stmt->execute();
            header("Location: ship-selection.php");
        }
    } elseif ($_POST['shipid'] > 0) {
        if ($_FILES["shipimg"]["error"] == UPLOAD_ERR_OK) {
            $target_file = getTargetFileName($_FILES["shipimg"]["name"]);
            if (uploadImage('shipimg', $target_file, $_POST['oldShipImgLocation']) !== true) {
                $target_file = "/uploads/cruise.png";
            }
        }

        $sql = "UPDATE `Ships` SET `Name`=?,`ImageLocation`=? WHERE `ShipID`=?;";
        $stmt = $db->prepare($sql);
        if ($stmt->bind_param("ssi", $_POST['shipname'], $target_file, $_POST['shipid'])) {
            $stmt->execute();
            header("Location: ship-selection.php");
        }
    }
}

if (!isset($_GET['shipid'])) {
    header("Location: ship-selection.php");
}

//load
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">

    <!-- <script type="text/javascript" src="http://livejs.com/live.js"></script> -->
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="category-selection.php">Ships Manager</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <img src="http://<?php echo $_SERVER['HTTP_HOST'] . $_GET['shipimg']; ?>" id="img-preview" style="height:100px;width:100px;">
                <div class="form-group">
                    <label for="image">Taswrira</label>
                    <input type="file" class="form-control-file" accept="image/*" name="shipimg" id="ship-image">
                </div>
                <div class="form-group">
                    <label for="name">Esem</label>
                    <input type="text" class="form-control" name="shipname" id="name" value="<?php echo $_GET['shipname'] ?>" required>
                </div>
                <input type="hidden" name="shipid" value="<?php echo $_GET['shipid']; ?>">
                <input type="hidden" name="oldShipImgLocation" value="<?php echo $_GET['shipimg']; ?>">
                <input type="hidden" name="shipOldName" value="<?php echo $_GET['shipname']; ?>">
                <button type="submit" class="btn btn-success float-right"><?php echo ($_GET['shipid'] == 0) ? "add" : "save"; ?></button>
            </form>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="../scripts/edit-ship-info.js"></script>
</body>

</html>
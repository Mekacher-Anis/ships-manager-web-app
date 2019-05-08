<!DOCTYPE html>

<?php
$file = basename($_SERVER['PHP_SELF']); // your file name
$last_modified_time = filemtime($file);
$etag = md5_file($file);

header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
header("Etag: $etag");
?>

<?php
include "../includes/dbconfig.php";


if(!isset($_GET['uid']) OR !isset($_GET['token']))
    die();
//SELECT token for this email address
$sql = 'SELECT token FROM `AccountConfirmation` WHERE UID=?;';
$stmt = mysqli_stmt_init($db);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $_GET['uid']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token);
    mysqli_stmt_fetch($stmt);
    $binToken = hex2bin($_GET['token']);

    //if the stored token and the token in the link match change the password
    if (password_verify($binToken,$token)) {
        //update user account to active state
        $sql = 'UPDATE Users SET Active=? WHERE UID=?;';
        $stmt = mysqli_stmt_init($db);
        $state = 1;
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ii',$state,$_GET['uid']);
            mysqli_stmt_execute($stmt);
        }

        //DELETE the stored token
        $sql = "DELETE FROM `AccountConfirmation` WHERE UID=" . $_GET['uid'] . ";";
        $query = mysqli_query($db, $sql);
        mysqli_execute($query);
    }
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">

    <script type="text/javascript" src="http://livejs.com/live.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="#">Social Synergy</a>
    </nav>

    <div class="container main-cont">
        <div class="card col-md-6 p-5 mx-auto my-auto justify-content-center" style="margin-top: 50px">
            <p class="alert alert-success">Account Has bin successfully confirmed.</p>
            <a href="../index.php">Log In</a>
        </div>
    </div>

    <footer class="footer bg-light text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
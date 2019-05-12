<?php
session_start();
if (!isset($_SESSION['username']))
    header('Location: ../index.php');

if (isset($_GET["logout"])) {
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Ships Manager</a>
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
        <div class="jumbotron text-center my-5 p-1">
            <div class="form-inline">
                <div class="form-group mx-auto mx-md-0">
                    <label class="mx-3" for="time-period">Period</label>
                    <input list="period-list" value="1 Month" class="form-control" id="time-period" onclick="$(this).val('')" onchange="loadData();">
                    <datalist id="period-list">
                        <option value="1 Month"></option>
                        <option value="6 Months"></option>
                        <option value="1 Year"></option>
                    </datalist>
                </div>
            </div>

            <div class="my-3" id="info">
                <h4 class="d-inline text-primary">Mad5oul L'jomli : </h4>
                <h4 class="d-inline" id="gain-label">0</h4><br>
                <h4 class="d-inline text-info">7rouguat : </h4>
                <h4 class="d-inline" id="expenses-label">0</h4><br>
                <h4 class="d-inline text-success">Reba7 Safi : </h4>
                <h4 class="d-inline" id="net-gain-label">0</h4><br>
            </div>

            <div class="row justify-content-center">
                <div class="ct-chart ct-square my-5 col-12 col-md-5" id="expenses-chart"></div>
                <div class="ct-chart ct-perfect-fourth col-12 col-md-5 my-auto" id="gain-chart"></div>
            </div>
        </div>
    </div>

    <footer class="footer bg-primary text-center">
        <p>Ships Manager Copyright &copy; </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

    <script src="../scripts/statistics.js"></script>

</body>

</html>
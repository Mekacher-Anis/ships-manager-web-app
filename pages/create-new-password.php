<?php
$file = basename($_SERVER['PHP_SELF']);
$last_modified_time = filemtime($file);
$etag = md5_file($file);

header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
header("Etag: $etag");
?>

<?php
require "../includes/dbconfig.php";
session_start();

$error = '';
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['password']) OR empty($_POST['conf-password'])) {
        $error = "Please fill all required fields";
    } elseif ($_POST['password'] != $_POST['conf-password']) {
        $error = 'Passwords do not match';
    } else {

        //SELECT token for this email address
        $pass = mysqli_real_escape_string($db, $_POST['password']);
        $confPass = mysqli_real_escape_string($db, $_POST['conf-password']);
        $sql = 'SELECT token FROM `pwd_reset` WHERE Email=? AND expiration_date > ?;';
        $stmt = mysqli_stmt_init($db);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $date = date('U');
            mysqli_stmt_bind_param($stmt, 'ss', $_POST['email'], $date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $token);
            mysqli_stmt_fetch($stmt);
            $binToken = hex2bin($_POST['token']);

            //if the stored token and the token in the post request match change the password
            if (password_verify($binToken,$token)) {
                $sql = 'UPDATE Users SET Password=? WHERE Email=?;';
                $stmt = mysqli_stmt_init($db);
                $hashed_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ss', $hashed_pass, $_POST['email']);
                    mysqli_stmt_execute($stmt);
                    $msg = "Password has been reset successfully";
                }

                //DELETE the stored token
                $sql = "DELETE FROM pwd_reset WHERE Email= '" . $_POST['email'] . "';";
                $query = mysqli_query($db, $sql);
                mysqli_execute($query);

            } else {
                $error = "Invalid Token.<br>Please re-submit your reset request.";
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
  <title>Test</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="../styles/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">

  <script type="text/javascript" src="http://livejs.com/live.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand" href="../index.php">Ships Manager</a>
  </nav>

  <div class="container main-cont">
    <div class="card col-md-6 p-5 mx-auto" style="margin-top: 50px">
      <form method="post" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
        <p class="display-4 text-center">Reset Password</p>
        <?php if (!empty($error)) {?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
        <?php }?>
        <?php if (!empty($msg)) {?>
          <div class="alert alert-success" role="alert">
            <?php echo $msg ?>
          </div>
        <?php }?>
        <div class="form-group">
          <label for="email">New Password</label>
          <input type="password" class="form-control" id="email" name="password" placeholder="password" required>
        </div>
        <div class="form-group">
          <label for="password">Confirm New Password</label>
          <input type="password" class="form-control" id="password" name="conf-password" placeholder="Password" required>
        </div>
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <button type="submit" class="btn btn-primary float-right">reset</button>
      </form>
    </div>
  </div>

  <footer class="footer bg-primary text-center">
    <p>Ships ManagerCopyright &copy; </p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
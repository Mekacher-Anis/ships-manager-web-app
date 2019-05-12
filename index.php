<?php
  $file = basename($_SERVER['PHP_SELF']); // your file name
  $last_modified_time = filemtime($file);
  $etag = md5_file($file);

  header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
  header("Etag: $etag");
?>

<?php
  require("includes/dbconfig.php");
  session_start();

  if(isset($_SESSION['username']))
        header('Location: ../pages/ship-selection.php');

  $error = '';
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(!empty($_POST['email']) and !empty($_POST['password'])){
          $mail = mysqli_real_escape_string($db,$_POST['email']);
          $pass = mysqli_real_escape_string($db,$_POST['password']);
          $sql = "SELECT * FROM Users WHERE Email = '".$mail."';";
          $query = mysqli_query($db,$sql);
          $row = mysqli_fetch_assoc($query);
          $num = mysqli_num_rows($query);
          if($num == 1  && $row['Active'] != 1){
            $error = "Account still not confirmed.<br>Please check your Email.";
          }elseif(password_verify($pass,$row['Password']) ){
              $_SESSION['userid'] = $row['UID'];
              $_SESSION['username'] = $row['Name'] . " " .  $row['Lastname'];
              header('Location: /pages/ship-selection.php');
          } else {
            $error = "Either the email or password is incorrect";
          }
      } else {
          $error = "Please fill all required fields";
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

  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="styles/main.css">

  <script type="text/javascript" src="http://livejs.com/live.js"></script>
  <script src="scripts/main.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Ships Manager</a>
  </nav>

  <div class="container main-cont">
    <div class="card col-md-6 p-5 mx-auto" style="margin: 25px 0px">
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <p class="display-4 text-center">Login</p>
        <?php if(!empty($error)) {?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error?>
          </div>
        <?php }?>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <a class="float-left" href="/pages/reset-password-request.php">forgot password ?</a>
        <button type="submit" class="btn btn-primary float-right">Sign in</button>
      </form>
      <hr/>
      <a href="/pages/signup.php" class="mx-auto">Sign Up !</a>
    </div>
  </div>

  <footer class="footer bg-primary text-center">
    <p>Ships Manager Copyright &copy; </p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
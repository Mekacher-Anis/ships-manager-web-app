<?php
  $file = basename($_SERVER['PHP_SELF']); // your file name
  $last_modified_time = filemtime($file);
  $etag = md5_file($file);

  header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
  header("Etag: $etag");
?>

<?php
  require("../includes/dbconfig.php");
  require("../includes/utilities.php");
  require("../includes/reset-password-mail-template.php");
  session_start();

  $error = '';
  $msg = '';
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST['email'])){
        $error = "Please enter your email address";
      }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email address";
      }else{
          $token = random_bytes(32);

          #find and delete all previous tokens for this email available in the database
          $sql = "DELETE FROM `pwd_reset` WHERE Email = ?";
          $stmt = mysqli_stmt_init($db);
          if(mysqli_stmt_prepare($stmt,$sql)){
              mysqli_stmt_bind_param($stmt,'s',$_POST['email']);
              mysqli_stmt_execute($stmt);
          }
          #add token to database
          $hashed_token = password_hash($token,PASSWORD_DEFAULT);
          $expiration_date = date('U') + 1800; #half an hour
          $sql = "INSERT INTO `pwd_reset`(`Email`, `token`, `expiration_date`) VALUES (?,?,?)";
          $stmt = mysqli_stmt_init($db);
          if(mysqli_stmt_prepare($stmt,$sql)){
              mysqli_stmt_bind_param($stmt,'sss',$_POST['email'],$hashed_token,$expiration_date);
              mysqli_stmt_execute($stmt);
          }
          #send token url to email
          $link = $_SERVER['HTTP_HOST']."/pages/create-new-password.php?token=" . bin2hex($token) . "&email=" . $_POST['email'];
          $body = $firstPart . $link . $secondPart . $link . $thirdPart;
          $mailer = initMailer('smtp.gmail.com',587,'anis551999@gmail.com','adem987654321@','tls');
          sendMail($mailer,'no-reply@shipsmanager.com',true,'Password Reset',$body,$_POST['email']);

          $msg = 'Email Sent Successfully<br>Please Check your Email inbox.';
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

  <script type="text/javascript" src="http://livejs.com/live.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand" href="../index.php">Ships Manager</a>
  </nav>

  <div class="container main-cont">
    <div class="card col-md-6 p-5 mx-auto" style="margin-top: 50px">
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <p class="display-4 text-center">Reset Password</p>
        <?php if(!empty($error)) {?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error?>
          </div>
        <?php }?>
        <?php if(!empty($msg)) {?>
          <div class="alert alert-success" role="alert">
            <?php echo $msg?>
          </div>
        <?php }?>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">A link to reset your password will be sent to your email address</small>
        </div>
        <button type="submit" class="btn btn-primary float-right">Send Link</button>
      </form>
    </div>
  </div>

  <?php include "footer.php" ?>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
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
require "../includes/utilities.php";
session_start();

$error = '';
$msg = '';
$success = false; //registred or not
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) or empty($_POST['name']) or empty($_POST['lastname']) or
        empty($_POST['password']) or empty($_POST['conf-password'])) {
        $error = "Please fill all required fields";
    } elseif (emailAlreadyExists($_POST['email'])) {
        $error = "Email already registred";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address";
    } elseif (!checkPass($_POST['password'])) {
        $error = "Password must :<br><ul><li>contain at least one lower case letter and a number</li>
        <li>be longer than 8 charachters</li></ul>";
    }elseif ($_POST['password'] !== $_POST['conf-password']) {
      $error = "Passwords don't match";
  } else {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
        $mail = mysqli_real_escape_string($db, $_POST['email']);
        $pass = mysqli_real_escape_string($db, $_POST['password']);
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $date = date( 'Y-m-d' );
        $sql = "INSERT INTO `Users`(`Name`, `Lastname`, `Email`, `Password`, `DateCreated`) VALUES ('$name','$lastname','$mail','$hashed_pass','$date')";
        if (mysqli_query($db, $sql)) {
          #create token for account confirmation and add it to database
          $token = random_bytes(32);
          $UID = mysqli_insert_id($db);
          $hashed_token = password_hash($token,PASSWORD_DEFAULT);
          $sql = "INSERT INTO `AccountConfirmation`(`UID`, `token`) VALUES (?,?)";
          $stmt = mysqli_stmt_init($db);
          if(mysqli_stmt_prepare($stmt,$sql)){
              mysqli_stmt_bind_param($stmt,'is',$UID,$hashed_token);
              if(!mysqli_stmt_execute($stmt))
                die();
          }
          #send token url to email
          $link = $_SERVER['HTTP_HOST'] . "/pages/confirm-account.php?token=" . bin2hex($token) . "&uid=" . $UID;
          $body = $firstPart . $link . $secondPart . $link . $thirdPart;
          $mailer = initMailer('smtp.gmail.com',587,'anis551999@gmail.com','adem987654321@','tls');
          sendMail($mailer,'no-reply@shipsmanager.com',true,'Account Confirmation',$body,$_POST['email']);

          $msg = "Please Check your Email inbox.<br>We've sent you a confirmation email.";
          $success = true;
        }
    }
}
?>

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
    <div class="card col-md-6 p-5 mx-auto" style="margin: 50px 0px">
      <?php if(!empty($msg)) {?>
        <div class="alert alert-success" role="alert">
          <?php echo $msg?>
        </div>
      <?php }elseif(!$success){?>
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <p class="display-4 text-center">Sign Up</p>
        <?php if (!empty($error)) {?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
        <?php }?>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
          <label for="lastname">Lastname</label>
          <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label for="conf-password">Confirm Password</label>
          <input type="password" class="form-control" id="conf-password" name="conf-password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary float-right">Sign up</button>
      </form>
        <?php }?>
      <hr/>
      <a href="../index.php" class="mx-auto">Sign in</a>
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
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;

function checkPass($pass)
{
    $lowercase = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);

    if (!$lowercase || !$number || strlen($pass) < 8) {
        return false;
    } else {
        return true;
    }

}

function checkUsername($uploadName)
{
    //must start with a letter
    //must be 6-32 charachters long
    //contains numbers and letters only
    return preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $uploadName);
}

function nameAlreadyExists($uploadName)
{
    include "dbconfig.php";
    $sql = "SELECT UID FROM Users WHERE username = '" . $uploadName . "';";
    $query = mysqli_query($db, $sql);
    $number = mysqli_num_rows($query);
    mysqli_close($db);
    if ($number == 1) {
        return true;
    } else {
        return false;
    }

}

function emailAlreadyExists($email)
{
    include "dbconfig.php";
    $sql = "SELECT UID FROM Users WHERE Email = '" . $email . "';";
    $query = mysqli_query($db, $sql);
    $number = mysqli_num_rows($query);
    mysqli_close($db);
    if ($number == 1) {
        return true;
    } else {
        return false;
    }

}

function initMailer($host, $port, $username, $password, $security)
{
    require "../includes/phpmailer/autoload.php";

    $mail = new PHPMailer(false); //no exceptions
    //Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = $host; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = $username; // SMTP username
    $mail->Password = $password; // SMTP password
    $mail->SMTPSecure = $security; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $port; // TCP port to connect to

    return $mail;
}

function sendMail($mail, $sender, $isHTML, $subject, $body, ...$recipients)
{
    require "../includes/phpmailer/autoload.php";

    //Recipients
    $mail->setFrom($sender, 'Mailer');
    foreach ($recipients as $email) {
        $mail->addAddress($email);
    }
    //Content
    $mail->isHTML($isHTML); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();
}

function getTargetFileName($uploadName){
    $fileExt = strtolower(pathinfo($_FILES[$uploadName]["name"],PATHINFO_EXTENSION));
    $target_file = "/uploads/" . bin2hex(random_bytes(10)) . "." . $fileExt;
    return $target_file;
}

function getTargetExistingFileName($uploadName,$oldName){
    $fileExt = strtolower(pathinfo($_FILES[$uploadName]["name"],PATHINFO_EXTENSION));
    $existingFileName = strtolower(pathinfo($oldName,PATHINFO_FILENAME));
    $target_file = "/uploads/" . $existingFileName . "." . $fileExt;
    return $target_file;
}

function getTargetFileExt($uploadName){
    $fileExt = strtolower(pathinfo($_FILES[$uploadName]["name"],PATHINFO_EXTENSION));
    return $fileExt;
}

function uploadImage($uploadName,$target_file_name,$oldFileName)
{
    $msg = "";
    $target_file = ".." . $target_file_name;
    $fileExt = getTargetFileExt($uploadName);
    $uploadOk = 1;
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$uploadName]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES[$uploadName]["size"] > 500000) {
        $msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($fileExt != "jpg" && $fileExt != "png" && $fileExt != "jpeg"
        && $fileExt != "gif") {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return $msg;
// if everything is ok, try to upload file
    } else {
        // Check if file already exists, delete it
        if (file_exists($oldFileName)) {
            unlink(realpath($oldFileName));
        }
        if (move_uploaded_file($_FILES[$uploadName]["tmp_name"], $target_file)) {
            return true;
        } else {
            return false;
        }

    }
}

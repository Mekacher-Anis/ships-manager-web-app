<?php
require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['tempDir' => '../tmp']);
$mpdf->WriteHTML($_POST['html']);
$filename = "/tmp/" . hash("md5",$_SESSION['username']) . ".pdf";
$fileLocation = ".." . $filename;
if(file_exists($fileLocation))
    unlink($fileLocation);
$mpdf->Output($fileLocation);
echo $filename;
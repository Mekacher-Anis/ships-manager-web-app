<?php
require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['tempDir' => '../tmp']);
$mpdf->WriteHTML($_POST['html']);
$filename = "/tmp/" . bin2hex(random_bytes(8)) . ".pdf";
$fileLocation = ".." . $filename;
$mpdf->Output($fileLocation);
echo $filename;
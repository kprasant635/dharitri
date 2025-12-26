<?php
header('Content-Type: image/png');
require_once('vendor/autoload.php');
use Endroid\QrCode\QrCode;
$qrCode = new QrCode();
$qrCode
    ->setText("")
    ->setSize(300)
    ->setPadding(10)
    ->setErrorCorrection('high')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel('Here is Your QR Code')
    ->setLabelFontSize(16)
    ->render()
?>
<?php

require_once('vendor/qrcode/vendor/autoload.php');
use Endroid\QrCode\QrCode;

	
function printQR($data){
	$qrCode = new QrCode();
	$image = $qrCode
    ->setText($data)
    ->setSize(120)
    ->setPadding(10)
    ->setErrorCorrection('low')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabelFontSize(16)
    ->getDataUri();
	return $image;
}
function printQRSign($data){
	$qrCode = new QrCode();
	$image = $qrCode
    ->setText($data)
    ->setSize(150)
    ->setPadding(10)
    ->setErrorCorrection('low')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabelFontSize(16)
    ->getDataUri();
	return $image;
}
?>
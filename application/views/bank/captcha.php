<?php

$str = md5(microtime());;
$str = substr($str,0,6);
session_start();
 //$this->session->set_userdata($str);
$_SESSION['captcha'] = $str;
$img = imagecreate(100, 50);
imagecolorallocate($img, 355, 355, 355);
$txtcolor = imagecolorallocate($img, 0, 0, 0);
imagestring($img, 70, 20, 20, $str, $txtcolor);
header('Content: image/jpeg');
imagejpeg($img);

?>

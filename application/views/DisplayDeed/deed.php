<?php
$slno = $_GET['slno'];
$url = "http://10.177.88.81:9090/webservices/binarylink?key=760343c0dd8213e3930bbe389d4b0c7323797341&comcaseno=".$slno;
echo $url;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch); 
curl_close($ch);      
$d = explode(",", $output);
$data=base64_decode($d[1]);
header('Content-Type: application/pdf');
echo $data;
?>

<?php
//$slno = $_GET['slno'];
$slno='5638/2016';
$url = "http://10.177.88.81:9090/webservices/webresources/deedinfo?jsonp=deedinfo&circle_code=240103000000000&slno=".$slno;
echo $url;
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0); 
$output = curl_exec($ch); 
curl_close($ch);   
$d = json_encode($output) ;//explode(",", $output);  
//$d = explode(",", $output);
var_dump($d);
//var_dump($d[16]);
//header('Content-Type: application/pdf');
//echo $data;
deedinfo(
{"deed":
[{"slno":"5638/2016", "deedno":"Book-I/4175/2016","applicant":"Mihir Kt Biswas","amount":"1034000","office":"Kamrup Metro"}],
"party":null,
"landdetails":
[{"slno":30265,"caseslno":1,"comcaseno":"5638/2016","noofplot":1,"noofplotNull":false,"district":"Kamrup(M)","circle":"Dispur","mouza":"Beltola","village":"Jatia","villcode":"240103010110016","dagno":"1667","olddagno":"0","pattano":"1311","oldpattano":"0","barea":0,"bareaNull":false,"karea":0,"kareaNull":false,"larea":0.0,"lareaNull":false,"chatakarea":0.0,"chatakareaNull":false,"gandaarea":0,"gandaareaNull":false,"karaarea":0,"karaareaNull":false,"krantiarea":0.0,"krantiareaNull":false,"acre":0.0,"acreNull":false,"are":0.0,"areNull":false,"sqlfeet":700.0,"sqlfeetNull":false,"landcl":"All Class","pattatype":"0201","checkComplete":1,"districtCode":"24","sroCode":"01","south":null,"north":null,"east":null,"west":null}]
})
?>

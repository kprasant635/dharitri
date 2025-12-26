<?php
$myPDO = new PDO('pgsql:host=localhost;dbname=test_database', 'postgres', 'qwe123');

$result = "SELECT * FROM chita_basic";
?>
<table border="1">
    <tr><th colspan="3">Chitha Basic Table</th></tr>
  <tr>
   <th>Chitha Id</th>
   <th>Daag No</th>
   <th>Patta No</th>
  </tr>
<?php
foreach($myPDO->query($result) as $rs)
{
    echo "<tr><td>$rs[0]</td><td>$rs[1]</td><td>$rs[2]</td></tr>";
}
?>
</table>
<?php
$result1 = "SELECT * FROM jamabandi_basic";
?>
<table border="1">
    <tr><th colspan="3">Jamabandhi Basic Table</th></tr>
  <tr>
   <th>Jamabandhi Id</th>
   <th>Daag No</th>
   <th>Patta No</th>
  </tr>
<?php
foreach($myPDO->query($result1) as $rs1)
{
    echo "<tr><td>$rs1[0]</td><td>$rs1[1]</td><td>$rs1[2]</td></tr>";
}
?>
</table>
<?php

//$que = "SELECT daag_no,patta_no FROM jamabandi_basic WHERE daag_no,patta_no IN ('Select daag_no,patta_no from chita_basic')";
$que = "SELECT daag_no,patta_no FROM jamabandi_basic";
foreach($myPDO->query($que) as $row)
{
    //echo $row[0]."and".$row[1]."<br>";
    $que1 = "Select daag_no,patta_no from chita_basic where daag_no = '$row[0]' and patta_no = '$row[1]'";
    $stmt = $myPDO->prepare($que1);
    $stmt->execute();
    if($stmt->rowCount()==0)
    {
        echo "Daag No & Patta No Mismatch : <span style='color:Red;'>".$row[0]." and ".$row[1]."</span><br>";
    }
 else {
        $ro = $stmt->fetch();
        echo "Matching Daag No & Patta No : ".$ro[0]." and ".$ro[1]."<br>";
    }
    
    
}

?>

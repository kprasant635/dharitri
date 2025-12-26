<html>
<?php
	//Variables decleratrion, Post Value received, SQL string...........
	
	$cntPdar=0;
	$cntDag=0;
	$myCNT=0;
	$total_B=0;
	$total_K=0;
	$total_L=0;
	$g_areaB=0;
	$g_areaK=0;
	$totalLC=0;
	$d_rev=0;
	$d_ltax=0;
	$myCnt;
	$pno=0;
	$cnt=0;
	$tLine=0;
	$_SESSION["myCircle"]=$this->input->post('circle_name');
	$_SESSION["myVillage"]=$this->input->post('village_name');
	$_SESSION["myPattaType"]=$this->input->post('patta_type_name');
	$tLine=$this->input->post('rows');
	if ($tLine<2)
	{
		$tLine=2;
	}
	$pno=$this->input->post('patta_no');
	$dist_code = $this->input->post('dist_code');
	$subdiv_code = $this->input->post('subdiv_code');
	$circle_code = $this->input->post('cir_code');
    $mouza_code = $this->input->post('mouza_pargona_code');
	$lot_no = $this->input->post('lot_no');
	$vill_code = $this->input->post('vill_townprt_code');
	$_SESSION["lot_no"] = $this->input->post('lot_no');
	$_SESSION["patta_no"] = $this->input->post('patta_no');
	$pattacode = $this->input->post('patta_code');
	
	$patta_no=$this->input->post('patta_no');

	$patta_no = explode(",",$patta_no);
	$cnt_pattano=count($patta_no);
	/*for($i=0;$i<$cnt_pattano;$i++)
	{
		 echo "Patta No-" . $patta_no[$i] . "<br>";
	}
	echo "Rows :" . $tLine;
	break;*/
	$x=$pattaHead=0;
	while ($x<$cnt_pattano)
	{
	$pno=$patta_no[$x];
	
	//echo $pno;
	$sqlJP= $this->db->query("SELECT * FROM jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$pattacode'");
	$sqlDAG= $this->db->query("SELECT * FROM jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$pattacode'");
	$q= $this->db->query("SELECT count(*) as c1 FROM jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$pattacode'");
	$r= $this->db->query("SELECT count(*) as c2 FROM jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$pattacode'");
	foreach ($q->result() as $row)
					{
						$cntPdar=$row->c1;
					}
	foreach ($r->result() as $row)
					{
						$cntDag=$row->c2;
					}
	if ($cntPdar < $cntDag)
	{
		$myCnt=$cntPdar;
		//echo $myCnt."First";
	}
	else
	{
		$myCnt=$cntDag;
		$myCnt."Second";
	}
	//echo $patta_no[$x];
	//--------------------
	TableHeader($_SESSION["myCircle"],$_SESSION["lot_no"],$_SESSION["myVillage"],$_SESSION["myPattaType"],$pno);
	//CreateArrayforPDarDag($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$patta_no[$x],$patta_type,$sqlJP,$sqlDAG,$cntPdar,$cntDag,$myCnt,$ltARR,$areaARR,$tLine);
	CreateArrayforPDarDag($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$patta_no[$x],$patta_type,$sqlJP,$sqlDAG,$cntPdar,$cntDag,$myCnt,$tLine);
	$x++;
	}
?>
<?php
	function TableHeader($Circle, $lot_no,$Village, $PType, $pno)
	{
     echo "<body>";
     echo "<p align=left><font size=4>Assam Schedule XXIV (Part-I) Form No.6</font></p>";
	 echo "<table  width=100%>";
	 echo "<tr><td align=center colspan=2><font size=5>" . "জমা ওৱাছিল" . "</font></td></tr>";
     echo "<tr><td align=center><font size=4>" . "চক্ৰ :" . $Circle . "; লাট নং " . $lot_no . "; গাওঁৰ নাম : " . $Village . "(" . $PType . ")" . "</font></td><td></td></tr>"; 
	 echo "</table>";
   	 echo "</body>";
	 echo "<div class=container-fluid form-top>";
	 echo "<div class=row><div class=col-lg-12>";
	 echo " <table style='border:1px solid black;' width='100%' >";
     echo "<tr>";
     echo "<td style='border:1px solid black;' rowspan='2' align='center' width=5%\>পাট্টা-নং</td>";
     echo "<td style='border:1px solid black;' rowspan='2' align='center' width=25%\>ৰায়তৰ নিজ নাম আৰু পিতাৰ নাম</td>";
     echo "<td style='border:1px solid black;' colspan='2' align='center' width=20%>পাব লগা ধন</td>";
     echo "<td style='border:1px solid black;' colspan='4' align='center' width=40%\>আদায়</td>";
     echo "<td style='border:1px solid black;' rowspan='2' align='center' width=20%\>মন্তব্য</td>";
     echo "</tr><tr>";
	 echo "<td style='border:1px solid black;' align='center' width=13%\>ৰাজহ</td>";
     echo "<td style='border:1px solid black;' align='center' width=80>স্হানীয় কৰ</td>";
	 echo "<td style='border:1px solid black;' align='center' width=7%\>তাৰিখ</td>";
	 echo "<td style='border:1px solid black;' align='center' width=8%\>ৰাজহ</td>";
	 echo "<td style='border:1px solid black;' align='center' width=8%\>স্হানীয় কৰ</td>";
	 echo "<td style='border:1px solid black;' align='center' width=12%\>ক্ৰমিক নম্বৰ দৈনিক আমদানিৰ </td>";
	 echo "</tr>";
	 echo "<tr>";
     echo "<td style='border:1px solid black;' align='center'>1</td>";
     echo "<td style='border:1px solid black;' align='center'>2</td>";
	 echo "<td style='border:1px solid black;' align='center'>3</td>";
	 echo "<td style='border:1px solid black;' align='center'>4</td>";
	 echo "<td style='border:1px solid black;' align='center'>5</td>";
	 echo "<td style='border:1px solid black;' align='center'>6</td>";
	 echo "<td style='border:1px solid black;' align='center'>7</td>";
	 echo "<td style='border:1px solid black;' align='center'>8</td>";
	 echo "<td style='border:1px solid black;' align='center'>9</td></tr>";
	 echo "<tr style='border:1px solid black;'><td align='center'>" . $pno . "</td>";
	 }
//----------------------------
?>
 <?php
 //echo $pno;
  function CreateArrayforPDarDag($dist_code, $subdiv_code, $circle_code, $mouza_code,$lot_no, $vill_code, $pno, $patta_type,$sqlJP,$sqlDAG,$cntPdar,$cntDag,$myCnt,$tLine)
  {   
  	//Inseting Pattadar Names into ARRAY (pdarARR]
  		//echo $pno ."ghjgsahgdasd";
	    $cnt=0;
		$totalLine=$tLine;
		$totalPG=0;
		$pdarARR=array();
		$dagARR=array();
		$ltARR=array();
		$areaARR=array();
		$combineARR=array();
		//global $pdarARR;
		//global $dagARR;
		//global $ltARR;
		//global $areaARR;
		//global $combineARR;
		global $myCnt;
		$NewArrayPosition=0;
		global $myCircle;
		global $myVillage;
		global $myPattaType;
		$total_B=0;
		$total_K=0;
		$total_L=0;
		$d_rev=0;
		$d_ltax=0;
		$totalLC=0;
		$g_areaB=0;
		$g_areaK= intval($totalLC/20);
		foreach ($sqlJP->result() as $row)
					{ 
						$cnt++;
					  if ($row->p_flag=='1')
					       {
							$pdar="<font color='red'> '<strike style=HEIGHT: 1px>'" . $cnt . ")" .$row->pdar_name . ", " . $row->pdar_father . "</strike></font><br>";
					  	     //echo "</strike>";
						   }
					  else
					  	   {
						     $pdar= $cnt . ")" . $row->pdar_name . ", " . $row->pdar_father . "<br>";
						   }
						   $pdarARR[].=$pdar;
					 	}
	//Inserting DAG No, Revenue into the array $dagARR;
					foreach ($sqlDAG->result() as $row)
					{  
						$DagRevLTArea="Dag-" . $row->dag_no . ", " . "Rs." . number_format($row->dag_revenue,2) . "<br>";
						$ltax= "Rs." . number_format($row->dag_localtax,2) . "<br>";
						$darea= $row->dag_area_b . "B-" . $row->dag_area_k . "K-" . number_format($row->dag_area_lc,2) . "L"  . "<br>";
						$dagARR[].=$DagRevLTArea;
						$ltARR[].=$ltax;
						$areaARR[].=$darea;
						$total_B=($total_B +$row->dag_area_b);
				   		$total_K=($total_K + $row->dag_area_k);
				   		$total_L=($total_L + $row->dag_area_lc);
						$d_rev=($d_rev + $row->dag_revenue);
						$d_ltax=($d_ltax + $row->dag_localtax);
					}				
	//  Calculate the Grand total of Revenue, Local Tax and Land Area
					 $totalLC=($total_B*100 + $total_K * 20 + $total_L);
					 $g_areaB=intval($totalLC/100);
					 $totalLC=($totalLC % 100);
					 $g_areaK= intval($totalLC/20);
					 $totalLC= ($totalLC % 20);
	//======================================================
	//Adjust the array for Dags and Pattadar for equal no of rows.
	if ($cntPdar > $cntDag)
	{
	  for($i=$cntDag; $i<$cntPdar;$i++)
	  {
	   $dagARR[].=" ";
	   $ltARR[].=" ";
	   $areaARR[].=" ";
	  }
	}
	else 
	{
	   for($j=$cntPdar; $j<$cntDag; $j++)
	   {
	     $pdarARR[].=" ";
	   }
	}
	//If the Total Nos of Pattadar or Dags etc are less than 15 or equal to 15
	//than the following part will be executed.
	$myCnt1=count($pdarARR); 
	// Since all the arrays are made of same size, so any one can be used for getting the total no of records in Array.
	echo "<td style='border:1px solid black;'>";
	for($p=0;$p<$myCnt1;$p++)
		{ 
		  echo  $pdarARR[$p];
		  if ($p==($totalLine-1))
		   {
		    break;
		   }	
		} 
	
	echo "</td>";
	//----------------------For Dags, Revenue and Lcal Tax
	echo "<td style='border:1px solid black;'>";
	for($p=0;$p<$myCnt1;$p++)
		{ 
		  echo  "<font size=2>" . $dagARR[$p] . "</font>";
		  if ($p==($totalLine-1))
		   {
		     break;
		   }	
		  
		}
	 echo "Total Rs." . $d_rev;
	echo "</td>";
	//--------------------
	echo "<td style='border:1px solid black;'>";
	for($p=0;$p<$myCnt1;$p++)
		{ 
		  echo  $ltARR[$p];
		  if ($p==($totalLine-1))
		   {
		     break;
		   }	
		 }
	echo "Total Rs." .  $d_ltax;
	echo "</td>";	  
	//----------------------------------------------
	echo "<td style='border:1px solid black;'></td>"; //Column 5 
	echo "<td style='border:1px solid black;'></td>"; //Column 6
	echo "<td style='border:1px solid black;'></td>"; //Column 7
	echo "<td style='border:1px solid black;'></td>"; //Column 8
	echo "<td style='border:1px solid black;'>";
	for($p=0;$p<$myCnt1;$p++)
		{ 
		  echo  $areaARR[$p] ;
		  if ($p==($totalLine-1))
		   { 
			 $NewArrayPosition=($p+1);
			 break;
		   }	
		} 
	if ($myCnt<$totalLine)
	{
	 for($q=0;$q<($totalLine-$myCnt);$q++) //For managing the lines in the table the Smaller Counter between Padar and Area has be selected.
		{
	   		echo "&nbsp;</br>";
		}
	}
	echo "Total-" . $g_areaB ."B-" . $g_areaK . "K-" . $totalLC . "L<br>";
	echo "</td>";
	echo "</tr></table>";
	echo "<p align='center'> Page-1 </p>";
	echo "<div style='page-break-after:always' ></div>";
	$totalPG=count($pdarARR)/$totalLine;
	echo "</div></div></div>";
	//The following Part is for displaying the records after 15.
	//echo "adufgsdaui fsadf".$pno;
	//echo $_SESSION["pattaNo"]=$pno;
	//echo $this->session->set_userdata('pattaNo',$pno);
	//echo $_SESSION["pattaNo"];
	  if ( $myCnt1>$totalLine)
	  	
	  	  //Jumping Statement	  
		{   $pgno=1;
		    for($z=0; $z<($totalPG-1); $z++)
			{
			  	TableHeader($_SESSION["myCircle"],$_SESSION["lot_no"],$_SESSION["myVillage"],$_SESSION["myPattaType"],$pno);
				//==========================================
				echo "<td style='border:1px solid black;' width=25%\>";
				$c1=0;
				for($p=$NewArrayPosition;$p<$myCnt1;$p++)
				{ 
					$c1++;
				    echo  $pdarARR[$p];
				  if ($c1==$totalLine)
				   {
						break;
				   }	
				} 
				echo "</td>";
				$c1=0;
				echo "<td style='border:1px solid black;'>";
				for($p=$NewArrayPosition;$p<$myCnt1;$p++)
					{ $c1++;
					  echo  $dagARR[$p] ;
					    if ($c1==$totalLine)
				   			{
								break;
				   			}	
					}
				echo "</td>";
	//--------------------
				$c1=0;
				echo "<td style='border:1px solid black;'>";
				for($p=$NewArrayPosition;$p<$myCnt1;$p++)
					{ $c1++;
					  echo  $ltARR[$p];
					    if ($c1==$totalLine)
				  			 {
								break;
				   			 }		
					 }
				echo "</td>";	  
	//----------------------------------------------
				echo "<td style='border:1px solid black;'></td>";
				echo "<td style='border:1px solid black;'></td>";
				echo "<td style='border:1px solid black;'></td>";
				echo "<td style='border:1px solid black;'></td>";
				$c1=0;
				echo "<td style='border:1px solid black;'>";
				for($p=$NewArrayPosition;$p<$myCnt1;$p++)
					{ $c1++;
					  echo  $areaARR[$p] ;
					  if ($c1==$totalLine)
				  		{	 
						 $NewArrayPosition=($p+1);
						 break;
					   }	
					} 
				echo "</td>";
				echo "</tr></table>";
	//==========================================
			$pgno++;
			echo "<p align='center'>Page-" . $pgno  . "</p>";
			echo "<div style='page-break-after:always'></div>";
   } 
   }
  }// End of main bracket.........
 //----------------------------
?>
<table border="0">
                <tr>
                    <td align="center">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;Back to Main Meu</button>
						<input type=button value ="Print" onClick="javascript:window.print();" id=button2 name=button2>
                    </td>
                </tr>
</table>
     
</html>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () 
	{
        location.href = "<?php echo base_url() .  'index.php/MisReportControllerForJamawasil/districtDetailsForEnteringMultiplePattaNo'  ?>";
    };
	
</script>

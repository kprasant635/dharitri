<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10  panel panel-default panel-body  col-lg-offset-1">
            <?php
                   // var_dump($mutpartconv);
                    $apcancelattion_tot = $mutpartconv['registercase']->tot; //$mutpartconv['registercase']->tot;
                    $apcancelattion_delivered = $mutpartconv['chithacorrectcase']->deliver; //$mutpartconv['chithacorrectcase']->deliver;
                    $namecorrection_tot = $mutpartconv['register']->tot; //$mutpartconv['registercase']->tot;
                    $namecorrection_delivered = $mutpartconv['chithacorrect']->deliver;
                    
                    $reclass_tot = $mutpartconv['reclassreg']->tot; //$mutpartconv['registercase']->tot;
                    $reclass_delivered = $mutpartconv['reclasscorr']->deliver;
                    
                        if( $apcancelattion_tot == null){
                            $apcancelattion_tot=0;
                        }
                        if( $apcancelattion_delivered == null){
                            $apcancelattion_delivered=0;
                        }
                        if( $namecorrection_tot == null){
                            $namecorrection_tot=0;
                        }
                        if( $namecorrection_delivered == null){
                            $namecorrection_delivered=0;
                        }
                       
                    $FmutTot = ($mutpartconv['FMutTot']);
                    //var_dump($mutpartconv['FMutTot']);
                        $FMut = ($mutpartconv['FMut']);
                        $FMutPass = 0;
                        $FPartPass = 0;
                        $FMutCorr = 0;
                        $FPartCorr = 0;
                        $fmPass = 0;
						$fmPass1=0;
                        $fmCorr = 0;
                        $FMutPass1 = 0;
                        $FPartPass1 = 0;
            foreach($FMut AS $fmrow){
                $order_type_code=$fmrow->order_type_code;
                $iscorrected_inco=$fmrow->case_no;
				
				
                $new_dag_no=$fmrow->new_dag_no;
                //No of pass data for field mtation
                if($order_type_code=='01'){
					//if (in_array($case_array, $fmrow->case_no, false)){
						$FMutPass=$FMutPass+1;
					//}
                }
                elseif(($order_type_code=='02') and ($new_dag_no!=null) ){
                    $FPartPass=$FPartPass+1;
                }
                //Corrected data for field mtation
                if(($order_type_code=='01') && ($iscorrected_inco=='Y')){
                    $FMutCorr=$FMutCorr+1;
                }
                if(($order_type_code=='02') && ($iscorrected_inco=='Y')){
                    $FPartCorr=$FPartCorr+1;
                }
                $fmPass=$FMutPass+$FPartPass;
                $fmCorr=$FMutCorr+$FPartCorr;
            }
			//var_dump($mutpartconv['FMutTot']);
			foreach($mutpartconv['FMutTot'] as $tot)
			{
			$order_type_code=$tot->mut_type;
                
                //No of pass data for field mtation
                if($order_type_code=='01'){
                    $FMutPass1=$FMutPass1+1;
                }
                elseif($order_type_code=='02'){
                    $FPartPass1=$FPartPass1+1;
                }
                
                $fmPass1=$FMutPass1+$FPartPass1;
                
			}
            //#########################################################################
            //Office mutation Passed Cases
            $OMutPass=($mutpartconv['OMutPass']);
			//var_dump($mutpartconv['OMutPass']);
            
            $OMPass1=0;
            $OMPass2=0;
            $OMPass3=0;
            $OMPass4=0;
            $OMPass5=0;
            $OMPass6=0;
            $OMPass7=0;
            
            foreach ($mutpartconv['OMutPass'] AS $omrow){
				//var_dump($omrow);
				$mut_type=$omrow->mut_type;
                //01 conversion
                //03 mutation
                //04 partition
                if($mut_type=='01'){
                     $OMPass1=$OMPass1+1;
					//echo "<br>"."conv";
                }
                if($mut_type=='03'){
                     $OMPass3=$OMPass3+1;
				   //echo "<br>"."mut";
                }
                if($mut_type=='04'){
                     $OMPass4=$OMPass4+1;
					//echo "<br>"."part";
                }    
            }

             $totOMPass=$OMPass1+$OMPass3+$OMPass4+$apcancelattion_tot+$namecorrection_tot+$reclass_tot;
            //#########################################################################
            $OMutCorr=($mutpartconv['OMutCorr']);
            
            $OMCorrCount1=0;
            $OMCorrCount2=0;
            $OMCorrCount3=0;
            $OMCorrCount4=0;
            $OMCorrCount5=0;
            $OMCorrCount6=0;
            $OMCorrCount7=0;
            
            //Office mutation Corrected Cases
            foreach ($OMutCorr AS $omCorrrow){
				//var_dump($omCorrrow);
                $ord_type_code=$omCorrrow->ord_type_code;
                $iscorrected_inco=$omCorrrow->case_no;
                if(($ord_type_code=='01')){
                    $OMCorrCount1=$OMCorrCount1+1;
                }
                elseif(($ord_type_code=='03')){
                    $OMCorrCount3=$OMCorrCount3+1;
                }
                elseif(($ord_type_code=='04')){
                    $OMCorrCount4=$OMCorrCount4+1;
                }
                
            }
			//echo $OMCorrCount1;echo $OMCorrCount3;echo $OMCorrCount4;echo $apcancelattion_delivered;
			
            $totOMCorrCount= $OMCorrCount1+ $OMCorrCount3+$OMCorrCount4+$apcancelattion_delivered+$reclass_delivered+$namecorrection_delivered;
            
            $month_name = $this->utilityclass->getMonth($namedata['month']);
            ?>
            <div class="alert alert-success" role="alert">
                <h2 class="center">Monthly Account Of Mutation / Partition / Conversion Cases</h2> 
                
                <h3 class="center">Year : <?php echo $namedata['year'];?> &nbsp;&nbsp;&nbsp;&nbsp; Month : <?php echo $month_name;?></h3>
            </div>
            <hr>
            <table class="table table-bordered table_black" >
                <thead>
                    <tr class="center info">
                        <th>Sl No. </th><th>Mutation Type</th>
                        <th>No Of Cases for which Order has been Passed</th>
                        <th>No Of Cases for which Chitha has been Corrected</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="4">1</td><td class='success' colspan="3"><h3>Field Mutation</h3> </td>
                    </tr>
                    <tr class="center">
                        
                        <td>Mutation </td>
                        <td><?php echo $FMutPass1;?></td>
                        <td><?php echo $FMutPass;?></td>
                    </tr>
                    <tr class="center">
                       
                        <td>Partition</td>
                        <td><?php echo $FPartPass1;?></td>
                        <td><?php echo $FPartPass;?></td>
                    </tr>
                    <tr class="center danger">
                        
                        <td>Total</td>
                        <td><?php echo $fmPass1;?></td>
                        <td><?php echo $fmPass;?></td>
                    </tr>
                    
                    
                     <tr >
                         <td rowspan="9">2</td><td class='success' colspan="3" ><h3>Office Mutation</h3> </td>
                    </tr>
                     <tr class="center">
                        <td>Mutation </td>
                        <td><?php echo $OMPass3;?></td>
                        <td><?php echo $OMCorrCount3;?></td>
                    </tr>
                    <tr class="center">
                        <td>Partition</td>
                        <td><?php echo $OMPass4;?></td>
                        <td><?php echo $OMCorrCount4;?></td>
                    </tr>
                     <tr class="center">
                        <td>Conversion </td>
                        <td><?php echo $OMPass1;?></td>
                        <td><?php echo $OMCorrCount1;?></td>
                    </tr>
                    <tr class="center">
                        <td>NR Case</td>
                        <td><?php echo $apcancelattion_tot;?></td>
                        <td><?php echo $apcancelattion_delivered;?></td>
                    </tr>
                     <tr class="center">
                        <td>Name Correction </td>
                        <td><?php echo $namecorrection_tot;?></td>
                        <td><?php echo $namecorrection_delivered;//$OMCorrCount2;?></td>
                    </tr>
                     <tr class="center">
                        <td>Name Ommission </td>
                        <td><?php //echo $OMPass7;?></td>
                        <td><?php //echo $OMPass7;//$OMCorrCount7;?></td>
                    </tr>
                     <tr class="center">
                        <td>Reclassification </td>
                        <td><?php echo $reclass_tot;?></td>
                        <td><?php echo $reclass_delivered;//$OMCorrCount5;?></td>
                    </tr>
                    
                    <tr class="center danger">
                        <td>Total</td>
                        <td><?php echo $totOMPass;?></td>
                        <td><?php echo $totOMCorrCount;?></td>
                    </tr>
                    <tr>
                    <td class="text-center" colspan="9">
                        <button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu') ?></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
 <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/MisReportController1/MonthlyAccMutPartConv' ?>";
        };
    </script>

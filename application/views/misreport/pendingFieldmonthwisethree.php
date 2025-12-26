<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
             <?php
                    $name=$sdata['mut_type'];
                    if($name=='01')
                    {
                        $cnmae="Field Mutation";
                    }
                     elseif($name=='02')
                    {
                        $cnmae="Field Partition";
                    }
                   
            ?>
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text"><?php echo $this->lang->line('list_of_pending_cases_more_than_3_months');?> - <?php echo $cnmae; ?> </h2>
                
            </div>
             <p class="uni_text"> <?php echo $this->lang->line('district');?> : <u class='text-danger'><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?></u>
                <?php echo $this->lang->line('subdivision');?> : <u class='text-danger'><?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$sdata['subdiv_code']) ?></u>
                <?php echo $this->lang->line('circle');?> :<u class='text-danger'><?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$sdata['subdiv_code'],$sdata['cir_code']) ?></u></p>
            <table width="100%" class="table table-bordered" border="1">
                <tr class="active text-danger">
                    <td width="35"><div align="center"> <?php echo $this->lang->line('sl_no');?></div></td>
                    <td width="110"><p align="center">
                        <p align="center"> <?php echo $this->lang->line('submission_date');?></p></td>
                    <td width="174"><div align="center"> <?php echo $this->lang->line('case_no');?></div></td>
                    <td width="174"><p align="center"><?php echo $this->lang->line('applicant_name');?> <?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                   <td width="51"><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                    <td width="38"><div align="center"><?php echo $this->lang->line('lot_no');?></div></td>
                    <td width="64"><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                   
                   <td width="124"><p align="center"><?php echo $this->lang->line('time_taken_to_solve_the_case');?></p></td>
                    <td width="334"><div align="center"><?php echo $this->lang->line('status');?></div></td>
                </tr>
                <tr >
                    <td class="alert-teal "><div align="center">1</div></td>
                    <td class="alert-teal"><div align="center">2</div></td>
                    <td class="alert-teal"><div align="center">3</div></td>
                    <td class="alert-teal"><div align="center">4</div></td>
                    <td class="alert-teal"><div align="center">5</div></td>
                    <td class="alert-teal"><div align="center">6</div></td>
                    <td class="alert-teal"><div align="center">7</div></td>
                    <td class="alert-teal"><div align="center">8</div></td>
                    <td class="alert-teal"><div align="center">9</div></td>
                </tr>
                <?php
                $i=0;
                $j=1;
                //var_dump($day);
                foreach($pb as $d)
                 {
                    
                   if($day[$i]>=90)
                   {
                    ?>
                <tr>
                    <td><div align="center"><?php echo $j++; ?></div></td>
                    <td><div align="center"><?php echo date('d-m-Y',  strtotime($d->report_date)); ?></div></td>
                    <td><div align="center"><?php echo $d->case_no; ?></div></td>
                    <td><div align="center"><?php 
                    foreach( $petipart[$i] as $p)
                    {
                        echo $p->n."<br>";
                        $relation=$this->utilityclass->get_relation($p->r);
                        echo "<span class='text-danger'>(".$relation.":-".$p->g .")<br></span>";
                    }
                    //echo  $petipart[$i][$i]->n;
                    ?></div></td>
                    <td><div align="center"><?php echo $this->utilityclass->getMouzaName($d->dist_code,$d->subdiv_code,$d->cir_code,$d->mouza_pargona_code); ?></div></td>
                    <td><div align="center"><?php echo $d->lot_no; ?></div></td>
                    <td><div align="center"><?php echo $this->utilityclass->getVillageName($d->dist_code,$d->subdiv_code,$d->cir_code,$d->mouza_pargona_code,$d->lot_no,$d->vill_townprt_code   ); ?></div></td>
                    
                    <td><div align="center"><?php echo $day[$i]."&nbsp;Day(s)<br>";
                                                    if($day[$i]>60 and $day[$i]<90)
                                                    {
                                                        echo "More than 2 months..";
                                                    }
                                                    if($day[$i]>90)
                                                    {
                                                        echo "More than 3 months..";
                                                    }
                    
                    ?></div></td>
                    <td><div align="left">                     
                            <?php
                                if($d->order_passed=='Y')
                                {
                                    $q="SELECT * FROM t_Chitha_col8_Order where  Petition_no='$d->petition_no' ";
                                    $tc=$this->db->query($q)->row();
                                    if($tc->isCorrected_inCO=='Y')
                                    {
                                         $desc=$this->utilityclass->GetCaseStatus('09'); 
                                         echo "<p class='text-danger'>$desc</p>";
                                    }
                                    else
                                    {
                                        $desc=$this->utilityclass->GetCaseStatus('10'); 
                                     echo "<p class='text-danger'>$desc</p>";
                                    }
                                }
                                  if($d->sk_note==null)
                               {
                                   echo "<p class='text-info'>**    SK Note Pending</p>";
                               }
                               if($d->is_dispose=='Y' )
                               {
                                   $desc=$this->utilityclass->GetCaseStatus('06'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                               
                               if($d->is_dispose==null and $d->order_passed==null )
                               {
                                   $desc=$this->utilityclass->GetCaseStatus('02'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                              
                        ?>
                        </div></td>
                </tr>
                   <?php
                   }
                   $i++;}?>
            </table>
          <center><button class="btn btn-danger" onclick="backFunc()">Back to the Previous Page</button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
	function backFunc() {
		window.history.back();
	}
</script>



<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" > 
            <?php
                    $name=$newdata['mut_type'];
                    if($name=='03')
                    {
                        $cnmae="Office Mutation";
                    }
                     elseif($name=='04')
                    {
                        $cnmae="Office Partition";
                    }
                    elseif($name=='01')
                    {
                        $cnmae="Office Conversion";
                    }
                    //var_dump($newdata);
            ?>
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text"><?php echo $this->lang->line('villege_wise_pendency_list');?> - <?php echo $cnmae; ?>  </h2></div>
            <?php //var_dump($Noticegen); ?>
             <span class="label label-primary uni_text"> <?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?></span>
            <span class="label label-success uni_text"><?php echo $this->lang->line('subdivision');?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$newdata['subdiv_code']) ; ?></span>
             <span class="label label-warning uni_text"><?php echo $this->lang->line('circle');?> :  <?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$newdata['subdiv_code'],$newdata['cir_code']) ; ?></span>
            <span class="label label-info uni_text"><?php echo $this->lang->line('lot_no');?> : <?php echo $newdata['lot_no']; ?></span>
            <p><br></p>
           
            
          
            <table width="100%" class="table table-bordered" border="1">
                <tr class="active text-danger">
                    <td width="35"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td width="110"><p align="center"><?php echo $this->lang->line('application_no');?></p>
                        <p align="center"><?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('submission_date');?></p></td>
                   <td width="174"><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                    <td width="174"><p align="center"><?php echo $this->lang->line('applicant_name');?> <?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                    <td width="51"><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                    <td width="38"><div align="center"><?php echo $this->lang->line('lot_no');?></div></td>
                    <td width="64"><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                    <td width="334"><div align="center"><?php echo $this->lang->line('status');?></div></td>
                    <td width="204"><div align="center"><?php echo $this->lang->line('proceed');?></div></td>
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
                
                foreach($pb as $d)
                 { ?>
                <tr>
                    <td><div align="center"><?php echo $j; ?></div></td>
                    <td><div align="center"><span class="badge badge-primary"><?php echo $d->petition_no."</span><br>";echo date('d-m-Y',  strtotime($d->submission_date)); ?></div></td>
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
                                      
                    <td><div align="left">
                        <?php
                                if($d->not_fresh=='Y' and $d->status=='D')
                               {
                                   $desc=$this->utilityclass->GetCaseStatus('06'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                               if($d->notice_generated_yn=='Y')
                               {
                                   if($d->lm_note_yn=='Y')
                                   {
                                       echo "<p class='text-info'>LM submitted his Report </p>";
                                   }
                                   
                                   if($d->proceeding_yn==1 and $d->lm_note_yn=='Y')
                                   {
                                       $desc=$this->utilityclass->GetCaseStatus('05'); 
                                       echo "<p class='text-danger'>$desc</p>";
                                   }
                               }
                               if($d->sk_comment=='Y')
                               {
                                   $desc=$this->utilityclass->GetCaseStatus('16'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                               
							  
                               
                                if($d->not_fresh=='Y' and $d->status=='P' and $d->lm_note_yn==null)
                               {
                                   $desc=$this->utilityclass->GetCaseStatus('12'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                               if($d->not_fresh <>'Y' or $d->not_fresh==null)
                               {
                                  
								   $desc=$this->utilityclass->GetCaseStatus('11'); 
                                   echo "<p class='text-danger'>$desc</p>";
                               }
                               
                        ?>
                        </div></td>
                        <td><a href="<?php echo  base_url(); ?>index.php/MisReport/ProceedingDetails?sub=<?php echo $newdata['subdiv_code'] ?>&cir=<?php echo $newdata['cir_code'] ?>&case_type=<?php echo $name ?>&case_no=<?php echo $d->case_no ?>&petition_no=<?php echo $d->petition_no ?> " class="btn btn-primary"><?php echo $this->lang->line('see_order');?></a></td>
                </tr>
                <?php $j++;$i++;}?>
            </table>
            
            <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}

</script>



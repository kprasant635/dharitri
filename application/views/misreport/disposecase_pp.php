<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
             <?php
                    $name=$this->session->userdata('mut_type');
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
            ?>
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text"><?php echo $this->lang->line('dispose_case');?>- <?php echo $cnmae; ?> </h2>
                <p class="text-info"><?php echo $this->lang->line('during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate')))  ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate')))  ?></p>
            </div>
            <p class="uni_text"> <?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?>
                <?php echo $this->lang->line('subdivision');?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?>
                <?php echo $this->lang->line('circle');?> :<?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?></p>
            <table width="100%" class="table table-bordered" border="1">
                <tr class="active text-danger">
                    <td width="35"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td width="110"><p align="center"><?php echo $this->lang->line('submission_date');?></p>
                        <p align="center"><?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('application_date');?></p></td>
                    <td width="174"><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                    <td width="174"><p align="center"><?php echo $this->lang->line('applicant_name');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                    <td width="51"><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                    <td width="38"><div align="center"><?php echo $this->lang->line('lot_no');?></div></td>
                    <td width="64"><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                    <td width="110"><p align="center"><?php echo $this->lang->line('final_order_date');?></p>
                       </td>
                    <td width="124"><p align="center"><?php echo $this->lang->line('time_taken_for_dispose_case');?></p>
                        </td>
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
                    <td class="alert-teal"><div align="center">10</div></td>
                </tr>
                <?php
                $i=0;
                $j=1;
               // var_dump($tc);
                foreach($pb as $d)
                 { ?>
                <tr>
                    <td><div align="center"><?php echo $j; ?></div></td>
                    <td><div align="center"><?php echo date('d-m-Y',  strtotime($d->submission_date)); ?></div></td>
                    <td><div align="center"><?php echo $d->case_no; ?></div></td>
                    <td><div align="center"><?php 
                    foreach( $petipart[$i] as $p)
                    {
                        echo $p->n."<br>";
                        echo $p->g;
                    }
                    //echo  $petipart[$i][$i]->n;
                    ?></div></td>
                    <td><div align="center"><?php echo $this->utilityclass->getCircleName($d->dist_code,$d->subdiv_code,$d->cir_code); ?></div></td>
                    <td><div align="center"><?php echo $d->lot_no; ?></div></td>
                    <td><div align="center"><?php echo $this->utilityclass->getVillageName($d->dist_code,$d->subdiv_code,$d->cir_code,$d->mouza_pargona_code,$d->lot_no,$d->vill_townprt_code   ); ?></div></td>
                    <td><div align="center"><?php echo date('d-m-Y',  strtotime($d->date_of_order)); ?></div></td>
                    <td><div align="center"><?php echo $day[$i]."&nbsp;Day(s)";
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
                                   $q="SELECT * from t_Chitha_Rmk_Ordbasic where case_no='$d->case_no' and Year_no='$d->year_no' and Petition_no='$d->petition_no' ";
                                   //echo $q;
                                   $tc=$this->db->query($q)->row();
                                  // var_dump($tc);
                                   if($tc->iscorrected_inco=='Y')
                                   {
                                        $desc=$this->utilityclass->GetCaseStatus('09'); 
                                   echo "<p class='text-danger'>$desc</p>";
                                   }
                                    else {
                                         $desc=$this->utilityclass->GetCaseStatus('10'); 
                                   echo "<p class='text-info'>$desc</p>";
                                    }
                                  
                               }
                               
                        ?>
                        </div></td>
                </tr>
                <?php $j++;$i++;}?>
            </table>
        </div>
    </div>
</div>


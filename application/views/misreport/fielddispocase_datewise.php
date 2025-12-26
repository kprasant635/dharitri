<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
             <?php
                    $name=$this->session->userdata('mut_type');
                    if($name=='01')
                    {
                        $cnmae="Field Mutation";
                    }
                     elseif($name=='02')
                    {
                        $cnmae="Field Partition";
                    }
                   
            ?>
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text"><?php echo $this->lang->line('disposed_list');?> - <?php echo $cnmae; ?> </h2>
                <p class="text-info"><?php echo $this->lang->line('during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate')))  ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate')))  ?></p>
            </div>
            <p class="uni_text"> <?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?>
                <?php echo $this->lang->line('subdivision');?> : <?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?>
                <?php echo $this->lang->line('circle');?> :<?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?></p>
            <table width="100%" class="table table-bordered" border="1">
                <tr class="active text-danger">
                    <td width="35"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td width="110"><p align="center"><?php echo $this->lang->line('application_no');?></p>
                        <p align="center"><?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('application_date');?></p></td>
                    <td width="174"><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                    <td width="174"><p align="center"><?php echo $this->lang->line('applicant_name');?><?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                    <td width="51"><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                    <td width="38"><div align="center"><?php echo $this->lang->line('lot_no');?></div></td>
                    <td width="64"><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                    <td width="110"><p align="center"> <?php echo $this->lang->line('order_date');?> </p>
                      </td>
                    <td width="124"><p align="center"><?php echo $this->lang->line('time_taken_for_dispose_case');?></p></td>
                    
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
               // var_dump($tc);
                foreach($fb as $d)
                 { ?>
                <tr>
                    <td><div align="center"><?php echo $j; ?></div></td>
                    <td><div align="center"><?php echo date('d-m-Y',  strtotime($d->report_date)); ?></div></td>
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
                </tr>
                <?php $j++;$i++;}?>
            </table>
        </div>
    </div>
</div>



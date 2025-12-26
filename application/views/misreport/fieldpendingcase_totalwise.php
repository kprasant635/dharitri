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
            <div class="alert alert-dismissible alert-warning text-center"><h2 class="uni_text"><?php echo $this->lang->line('pendency_list');?> - <?php echo $cnmae; ?> </h2>
                <p class="text-info"><?php echo $this->lang->line('during_this_period');?> <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></p>
            </div>
            <p class="uni_text"> <?php echo $this->lang->line('district');?> : <u class="text-danger"><?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?></u>
                <?php echo $this->lang->line('subdivision');?> : <u class="text-danger"><?php echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')) ?></u>
                <?php echo $this->lang->line('circle');?> :<u class="text-danger"><?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?></u></p>
            <table width="100%" class="table table-bordered" border="1">
                <tr class="active text-danger">
                    <td width="35"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td width="110">
                        <p align="center"><?php echo $this->lang->line('submission_date');?></p></td>
                    <td width="174"><div align="center"><?php echo $this->lang->line('case_no');?></div></td>
                    <td width="174"><p align="center"><?php echo $this->lang->line('applicant_name');?> <?php echo $this->lang->line('and');?></p>
                        <p align="center"><?php echo $this->lang->line('father_name');?></p></td>
                    <td width="51"><div align="center"><?php echo $this->lang->line('mouza');?></div></td>
                    <td width="38"><div align="center"><?php echo $this->lang->line('lot_no');?></div></td>
                    <td width="64"><div align="center"><?php echo $this->lang->line('vill_town');?></div></td>
                   
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
                   
                </tr>
                <?php
                $i=0;
                $j=1;
                //var_dump($petipart);
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
                                    //$lot_status=sizeof($petipart[$i]);
                                    if ($d->sk_note == null) {
                                        echo "<p class='text-info'>**    SK Note Pending</p>";
                                    }
                                    if($d->order_passed==null and $d->is_dispose==null)
                                    {
                                         $desc=$this->utilityclass->GetCaseStatus('02'); 
                                        echo "<p class='text-danger'>* $desc</p>";
                                    }
                            ?>
                        </div></td>
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


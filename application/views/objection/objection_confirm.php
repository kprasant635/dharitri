<?php //var_dump($this->session->all_userdata()) ?>
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('write_petition_information');?></h3>
                </div>
                <div class="panel-body">
                 
                    <table class="table table-striped table-hover">
                        <tr class="success">
                            <td><?php echo $this->lang->line('district'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></td>
                            <td><?php echo $this->lang->line('subdivision'); ?> :<?php  echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')); ?></td>
                            <td><?php echo $this->lang->line('circle'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')); ?></td>
                        </tr>
                        <tr class="warning">
                            <td><?php echo $this->lang->line('mouza'); ?> :<?php  echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code')); ?></td>
                            <td><?php echo $this->lang->line('lot_no'); ?> :<?php  echo $this->utilityclass->getLotName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no')); ?></td>
                            <td><?php echo $this->lang->line('vill_town'); ?> :<?php  echo $this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'),$this->session->userdata('vill_code')); ?></td>
                        </tr>
                        <tr class="info">
                            <td><?php echo $this->lang->line('dag_no'); ?> :<?php  echo $this->session->userdata('dag_no'); ?></td>
                        <td><?php echo $this->lang->line('mutation_type'); ?> :<?php   $d=$this->utilityclass->getMutationTypeObject($this->session->userdata('mut_type')); 
                            echo $d->order_type; ?></td>
                        <td><?php echo $this->lang->line('case_no') ?>: <?php echo $this->session->userdata('case_no'); ?></td>
                        </tr>
                    </table>        
                    <hr>
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url()."index.php/objection/registerfinalconfirm";?>">
                        <h4>The Duration of Original Case Registered till date is :</h4>
                        <h4 class="text-danger"> <span class="badge badge-info"><?php echo $diff->d."</span> day(s) <span class='badge badge-info'>".$diff->m." </span> Month(s) <span class='badge badge-info'> ".$diff->y."</span>Year(s) Completed";   ?></h4>   
                           <div class="form-group">
                            <div class="col-lg-7 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary  uni_text"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
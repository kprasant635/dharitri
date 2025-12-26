<?php //var_dump($this->session->all_userdata()) ?>
<div class="row login form-top">
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
                        <td></td>
                        </tr>
                    </table>        
                    <hr>
                   
                    <h1 class="text-danger"> <?php
                       if($this->session->flashdata('set_message')){
                           echo $this->session->flashdata('set_message');
                       }
                        ?></h1>   
                        <p></p>
					<center><a href="<?php echo  base_url()?>index.php/home" class='btn btn-danger center'>Go Back to Home</a></center>	
					
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="container-fluid form-top login">
    <div class='row'>
        <?php
        $sql = "Select * from crop_code";
        $data = $this->db->query($sql)->result();
        ?>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <p class="text-center uni_text"> আবেদন পঞ্জীকৰণ ফৰ্ম <?php //echo $this->lang->line('citizen_apply_form')?> </p>
                <div class="row" style="margin-top: 15px">
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>  :<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                    <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?>  :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                </div>
                <hr>
                
                <div class="row">
                    <form class="form-horizontal unicode" action="<?php echo base_url(); ?>index.php/citizencontroller/LMSubmitIC" method="POST" >
                        <div class="form-group">
                             <p class=" uni_text center text-danger "><?php echo $this->lang->line('income_dtls');?> / ( <?php echo $cername=$this->utilityclass->getCertName($this->session->userdata('cert_codeNo')); ?> <?php echo $this->lang->line('applied_for_post')?>  )</p>                         
                         </div>
                                        
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('crop_nam')?></label>
                            <div class="col-lg-4 pdar_name">
                                <select class="form-control" name="crop_code">
                                    <option value="000"><?php echo $this->lang->line('select_crop')?></option>
                                    <?php foreach ($data as $d): ?>
                                    <option value="<?php echo $d->crop_code;?>"><?php echo $d->crop_name; ?></option>
                                    <?php endforeach;  ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('unit_produce')?></label>
                            <div class="col-lg-4 pdar_name">
                                <input type="number" required=""  name="unit_produce" class="form-control "  >

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('unit_price')?></label>
                            <div class="col-lg-4 pdar_name">
                                <input type="number" required="" name="unit_price" class="form-control "  >

                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('other_income')?></label>
                            <div class="col-lg-4 pdar_name">
                                
                                <input type="number" required="" name="other_income" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="center">
                            <a href="<?php echo base_url('index.php/CitizenController/LMStep1'); ?>" class="btn btn-primary uni_text"><< <?php echo $this->lang->line('previous_menu')?></a>
                            <button type="submit" class="btn btn-success uni_text   "><?php echo $this->lang->line('submit_button')?> >></button>
                           
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <?php if ($this->session->flashdata('message')): ?>
        <?php 
            echo '<div class="col-lg-10 col-lg-offset-1">
                <p style="color:red;">'.$this->session->flashdata('message').'</p>
            </div>';
        ?>
        <?php endif; ?>
    </div>
</div>
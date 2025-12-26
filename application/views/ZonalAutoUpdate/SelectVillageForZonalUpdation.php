
<style>
    .modal_body p{
        font-family: 'Calibri' !important;
    }
</style>
<div class="row login">
      <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-success"> <?=$this->session->flashdata('message');?></div>
        <?php endif; ?>  
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm mis_report bg-info">
                <h2 style="text-align: center;font-size: 28px">Update Zonal Information </h2>
            </div>        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location');?></h3>
                </div>
                <!-- Select Location Gaon -->
                <div class="panel-body">
                    <?php echo form_open(base_url('index.php/ZoneInformationController/getDagdetails'),array('method'=>'post'));?>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 uni_text  control-label">গাওঁ / চহৰ</label>
                            <div class="col-lg-9 mb-4">
                                <select class="form-control villageselect" id="select"  name="vill_code" required>
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
								<input type="hidden" name="Action" value="Search">
                                 <button type="submit" name="zonalsearch" id="zonalsearch" class="btn btn-success zonalsearch"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
                <!-- Select Location Gaon End-->
            </div>
        </div>
    </div>
</div>


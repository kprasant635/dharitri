<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">  
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Next Date of Hearing for Case Number : <?php echo $this->session->userdata('case_no'); ?></h3>
                </div>
				<?php echo validation_errors(); ?>
                <div class="panel-body">
                    <form class="form-horizontal unicode" method='post' action="<?php echo base_url()."index.php/APCancellation/updateProDate";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Date</label>
                            <div class="col-lg-3">
                                <input class='form-control' placeholder='Click here to Change Date' required name='update_date' id='popupDatepicker' >
								<input type='hidden'  required name='case_no' value='<?php echo $this->session->userdata('case_no');?>' />
                            </div> 
                        </div>
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
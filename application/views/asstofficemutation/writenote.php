<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center;">
                    Note of Action Taken on Proceeding Order for Office Mutation Cases
                </h2>
                <?php
                            if($this->session->flashdata('message')){
                        ?>
<div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
  </div>
                        <?php
                            }
                        ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel ">
            <div class="panel-heading">
                <div class="panel-title">
                    <br>
                    <p class='center uni_text'>Order Sheet, dated from <?php echo date('d-m-Y', strtotime($location['date'])); ?> to <?php echo date('d-m-Y', strtotime($location['date_of_hearing'])); ?> district <?php echo $location['dist']; ?><br>Case No <?php echo $location['case_no']; ?>
					<br>
					<?php 
					if($location['application_ref_no']){
					echo "অনলাইনত উল্লেখ নং : ".$location['application_ref_no'];
					}
					?></p>
                </div>
            </div>
            <div class="panel-body form_1">
                <form class="unicode" method="post" enctype="multipart/form-data">
                    <?php if(ESCALATION_ENABLE ==1){ ?>
                        <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                    <?php } ?>
                    
                    <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <table class="table table-bordered" style="font-size: 16px;">
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label"><?php echo $this->lang->line('sl_no_and_date_of_order'); ?></label></td>
                                <td width="40%"><label class="control-label"><?php echo $this->lang->line('order_and_signature_of_officer'); ?></label></td>
                                <td width="40%"><label class="control-label"><?php echo $this->lang->line('note_of_action_taken_on_order'); ?></label></td>
                            </tr>
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label" >১</label></td>
                                <td><label class="control-label" >২</label></td>
                                <td><label class="control-label" >৩</label></td>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($details as $case):
                                ?>
                                <tr>
                                    <td><label class="control-label" ><?php echo "(" . $i++ . ") " . date('M jS, Y', strtotime($case->date_entry)); ?></label></td>
                                    <td>
                                        <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                        <label class="control-label" ><?php echo $case->co_order; ?></label></td>
                                    <td>
                                        <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                        <?php
                                        if (strlen($case->note_on_order) != NULL) {
                                            ?>
                                            <?php echo $case->note_on_order; ?>
                                            <input type="hidden" name="note[<?php echo $case->proceeding_id;?>]" class="form-control" value="<?php  echo str_replace("\xc2\xa0",'',$case->note_on_order);   ?>"/>
                                            <?php
                                        } else {
                                            ?>
                                            <textarea name="note[<?php echo $case->proceeding_id;?>]" class="form-control" rows="8">ভূমিলেখ্য সহায়ক প্ৰতিবেদন দিব|</textarea>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <!-- /////////ESCALATION REMARK///////////// -->
                          <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $es_flag == 1) { ?>
                            <div class="col-lg-12">
                                <div class="form-group col-md-4 text-right">
                                    <label class="red"> Cause For the case has not been pass in the timeline : </label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                </div>
                            </div>
                          <?php } ?>
                    </div>
                    <!-- Upload File -->
                     <div class="form-group col-sm-12">
                            <label for="inputEmail" class="col-lg-3 required  control-label">Upload Signed-Copy Report</label>
                            <div class="col-lg-3">
                                <input type='file' name="upload_consent_report" id="upload_consent_report" accept=".pdf, .jpg, .jpeg, .png, .gif" required>
                            </div>
                    </div>
                    <!-- end  -->
                    <center>
                        <button type="submit" name="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                        <a href="<?php echo base_url(); ?>index.php/officemutation/getPendingactionTakenReport" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                        </a>
                    </center>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
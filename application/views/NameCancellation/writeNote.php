<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center;">
                    Note of Action Taken on Proceeding Order for Name Cancellation Cases
                </h2>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel ">
            <div class="panel-heading">
                <div class="panel-title">
                    <br>
                    <p class='center uni_text'>Order Sheet, dated from <?php echo date('d-m-Y', strtotime($location['date'])); ?> to <?php echo date('d-m-Y', strtotime($location['date_of_hearing'])); ?> district <?php echo $location['dist']; ?><br>Case No <?php echo $location['case_no']; ?>
					<br>
					</p>
                </div>
            </div>
            <div class="panel-body form_1">
                <form class="unicode" method="post">
                    <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                    <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <table class="table table-bordered" style="font-size: 16px;">
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label"><?php echo $this->lang->line('sl_no_and_date_of_order'); ?></label></td>
                                <td><label class="control-label"><?php echo $this->lang->line('order_and_signature_of_officer'); ?></label></td>
                            </tr>
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label" >১</label></td>
                                <td><label class="control-label" >২</label></td>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($details as $case):
                                ?>
                                <tr>
                                    <td><label class="control-label" ><?php echo "(" . $i++ . ") " . date('M jS, Y', strtotime($case->note_date)); ?></label></td>
                                    <td>
                                        <input type="hidden" name="case_no" value="<?php echo $case->misc_case_no; ?>" />
                                        <label class="control-label" ><?php echo $case->process_note; ?></label></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            
                        </table>
                        <table class="table table-bordered" style="font-size: 16px;">
                             <tr style="color:#0000cc; text-align: center;">
                                
                                <td ><label class="control-label"><?php echo $this->lang->line('note_of_action_taken_on_order'); ?></label></td>
                            </tr>
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label" >৩</label></td>
                            </tr>
                            <tr>
                                <td>
                                    <textarea name="note" class="form-control" rows="8">&nbsp; প্ৰতিবেদন দিব |</textarea>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                    <center>
                        <button type="submit" name="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                        <a href="<?php echo base_url(); ?>index.php/NameCancellation/getPendingactionTakenReport" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                        </a>
                    </center>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
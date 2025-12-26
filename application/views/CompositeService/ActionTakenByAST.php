<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center;">
                    Note of Action Taken on Proceeding Order for Office Mutation Cases
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
                            <?php
                            if($location['application_ref_no']){
                                echo "অনলাইনত উল্লেখ নং : ".$location['application_ref_no'];
                            }
                            ?></p>
                    </div>
                </div>
                <div class="panel-body form_1">
                    <form method="post" id="form_submit" action="<?= base_url()?>index.php/CompositeService/submitActionTakenByAST">
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
                                if(isset($details)){
                                foreach ($details as $case):
                                    ?>
                                    <tr>
                                        <td><label class="control-label" ><?php echo "(" . $i++ . ") " .
                                                    date('M jS, Y', strtotime($case->date_entry)); ?></label>
                                        </td>
                                        <td>
                                            <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                            <label class="control-label" ><?php echo $case->co_order; ?></label></td>
                                        <td>
                                            <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                            <?php
                                            if (strlen($case->note_on_order) != NULL) {
                                                ?>
                                                <?php echo $case->note_on_order; ?>
                                                <input type="hidden" name="note[<?php echo $case->proceeding_id;?>]"
                                                       class="form-control" value="<?php echo $case->note_on_order; ?>"/>
                                                <?php
                                            } else {
                                                ?>
                                                <textarea name="note[<?php echo $case->proceeding_id;?>]"
                                                      class="form-control" rows="8">&nbsp;লট মন্ডলে প্ৰতিবেদন দিব |</textarea>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; } ?>
                            </table>
                        </div>
                        <center>
                            <div id="message_show"></div>
                            <div id="submit_btn">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                            <a href="<?php echo base_url(); ?>index.php/CompositeService/getPendingCasesForActionTaken" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;Back to Pending Cases
                            </a>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#form_submit').submit(function (e) {
        if(!confirm("Do you sure want to submit report?"))
        {
            $('#submit_btn').show();
            e.preventDefault();
        }
        else {
            $('#submit_btn').hide();
            $('#message_show').html("<span class='green p-2 bold'>Don't refresh the page until the process is completed... </span>");
        }
    })
</script>
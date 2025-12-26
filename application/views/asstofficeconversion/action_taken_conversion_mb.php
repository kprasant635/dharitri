<div class="row login panel-form">
    <div class="col-lg-12 center-col">
        <div class="panel ">
            <div class="panel-heading">
                <p align="left" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                    অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ 
                </p><br>
                <p align="right" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                    <?php echo $this->lang->line('name'); ?> : 
                    <?php
                    foreach ($p_in_order as $pop):
                        echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                    endforeach;
                    ?>
                </p>
                <div class="panel-title">
                    <p class='center bold uni_text'>নিৰ্দেশৰ তালিকা</p>
                    <p class='center uni_text'><u>(১৯১১ ৰেৰ্কড সহায়িকাৰ ১২৯ নং অনুসুচী চাঁওক)</u></p>
                    <br>
                    <p class='center uni_text'>Order Sheet, dated from <?php echo date('d-m-Y', strtotime($location['date'])); ?> to <?php echo date('d-m-Y', strtotime($location['date_of_hearing'])); ?> district <?php echo $location['dist']; ?><br>Case No <?php echo $location['case_no']; ?></p>
                </div>
            </div>
            <div class="panel-body form_1">
                <form class="unicode" action="<?php echo base_url($post_url); ?>" method="post" enctype="multipart/form-data">
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
                            foreach ($cases as $case):
                                ?>
                                <tr>
                                    <td><label class="control-label" ><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></label></td>
                                    <td>
                                        <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                        <label class="control-label" ><?php echo $case->co_order; ?></label></td>
                                    <td>
                                        <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                        <?php
                                        if (strlen($case->note_on_order) != NULL) {
                                            ?>
                                            <?php echo $case->note_on_order; ?>
                                            <input type="hidden" name="note_on_order[]" class="form-control" value="<?php echo $case->note_on_order; ?>"/>
                                            <?php
                                        } else {
                                            ?>
                                            <textarea name="note_on_order[]" class="form-control" rows="8"></textarea>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <center>
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-3 required  control-label">Action Taken Report</label>
                                    <div class="col-lg-6">
                                     <textarea name="action_taken_ast" rows="5" cols="80" required></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row pt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-3 required  control-label">Upload Notice</label>
                                    <div class="col-lg-3">
                                        <input type='file' name="up_notice_conv" id="up_notice_conv" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                        <button id="btnSub" type="submit" name="submit" class="btn btn-success uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_report'); ?></button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script>
    $(function () {
        $("#btnSub").click(function () {
          var up_notice_conv = document.getElementById('up_notice_conv').files[0];
          if(up_notice_conv == undefined) {
              swal.fire("", "Notice Document is a required parameter", "error")
              .then((value) => {

              });
              return false;
          }
        });
    });
</script>



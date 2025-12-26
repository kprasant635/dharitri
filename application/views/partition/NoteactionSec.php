<div class="contanier form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <h2 class="center">ORDER SHEET</h2>
            <p class="center">See Rule of 129 Records Manual 1911</p>
            <div style="margin-top: 10px">
                <p class="center">Order Sheet,  Dated From <?php echo date('m-d-Y', strtotime($stdate->stdate)); ?> to <?php echo date('m-d-Y', strtotime($endate->endate));
; ?> District : <?php echo $NameDist['dist'] ?> </p>
                <p class="center">Case No : <?php echo $pb->case_no; ?></p>
            </div>
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
            <form action="<?php echo base_url(); ?>index.php/partition/SaveNoteAction" method="post" enctype="multipart/form-data">
                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                    <table class="table table-bordered" style="font-size: 16px; background: #fff">
                        <tr style="color:#0000cc; text-align: center;">
                            <td>Serial No and Date of Order</td>
                            <td width="40%">Order and Signature of Officer</td>
                            <td width="40%">Note Of Action Taken on Order</td>
                        </tr>
                        <tr style="color:#0000cc; text-align: center;">
                            <td>১</td>
                            <td>২</td>
                            <td>৩</td>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($pd as $case):
                            ?>
                            <tr>
                                <td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                <td>
                                    <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                    <?php echo $case->co_order; ?></td>
                                <td>
                                    <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                    <textarea name="note_on_order[]" rows="5" cols="8" class="form-control"><?php echo $case->note_on_order; ?></textarea>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </table>
                    <!-- Upload File -->
                     <div class="form-group col-sm-12">
                            <label for="inputEmail" class="col-lg-3 required  control-label">Upload Signed-Copy Report</label>
                            <div class="col-lg-3">
                                <input type='file' name="upload_consent_report" id="upload_consent_report" accept=".pdf, .jpg, .jpeg, .png, .gif" required>
                            </div>
                    </div>
                    <!-- end  -->
                </div>
                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                    <button type="submit" name="submit" class="btn btn-danger"><span class="ass-btn"><?php echo $this->lang->line('report_submit') ?></span></button>
                </div>
            </form>

        </div>
    </div>
</div>




<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Land Proposed for Legacy Data Modification / Updations </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Dag Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' method="post" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['dist']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['sub']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['cir']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $location['mouza']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['lot']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $location['vill']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?php echo $Pcases->dag_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->patta_no; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['patta_type']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $det['old_land_class']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_revenue, 2); ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_localtax, 2); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group alert alert-success">
                                <label for="inputEmail3" class="col-sm-2 control-label"><span class="ass-btn">Land Area</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_b; ?> বিঘা" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_k; ?> কঠা" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_lc, 2); ?> লেছা" readonly>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
						<div class="form-group">
                                <div class="col-lg-10 col-lg-offset-3">
                                    <a href="javascript:void(0);" data-path="<?php echo search_file_location('LDUDocs/'. $Pcases->file_upload); ?>" class="preview__file btn btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;Verify Documents Uploaded
                                    </a>
                                    <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=" . $Pcases->proposal_no . "&case_id=" . $Pcases->case_no; ?>" class="btn btn-info" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;Verify Chitha
                                    </a>
                                    <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=" . $Pcases->proposal_no . "&case_id=" . $Pcases->case_no; ?>" target="_blank" class="btn btn-info">
                                        <i class="fa fa-paperclip"></i>&nbsp;Verify Jamabandi
                                    </a>
                                </div>
                        </div>
                        <form class='form-horizontal' method="post" action="<?php echo base_url(); ?>index.php/LegacyDataUpdation/manaualcorrection">
                            <h2><mark>Lot Mondal's Note</mark></h2>
                            <textarea class="form-control" readonly rows="5"><?php echo $Pcases->lm_note; ?></textarea>
                            <h2><mark>Circle Officer(s) Note On Action</mark></h2>
                            <textarea class="form-control" readonly rows="5"><?php echo $Pcases->co_note; ?></textarea>
                            <h2><mark>DC/ADC(s) Note On Action</mark></h2>
                            <textarea class="form-control" readonly rows="5"><?php echo $Pcases->dc_adc_note; ?></textarea>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark>Circle Officer(s) Final Order</mark></h2>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="co_final_report" class="form-control" rows="5"> </textarea>
                                    <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['co_name'] . ", "; ?><?php echo "চক্র বিষয়া, " . $location['cir']; ?></textarea>
                                    <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                                    <input type="hidden" class="form-control" name='case_type' value="<?php echo $Pcases->case_type; ?>" >
                                </div>
                                <hr>
                                <div class="col-sm-12">
                                    <label class="rasid col-sm-12">
                                            <?php
                                            if ($Pcases->case_type == 'D'){
                                                $modify= 'দাগ নং শুধৰণী';
                                            } else if ($Pcases->case_type == 'P') {
                                                $modify= 'পাট্টা নং শুধৰণী';
                                            } else if ($Pcases->case_type == 'PT') {
                                                $modify= 'পাট্টাৰ প্ৰকাৰ শুধৰণী';
                                            } else if ($Pcases->case_type == 'L') {
                                                $modify= 'মাটিৰ শ্ৰেণী শুধৰণী';
                                            } else if ($Pcases->case_type == 'LA') {
                                                $modify= 'মাটিৰ কালি শুধৰণী';
                                            } else if ($Pcases->case_type == 'R') {
                                                $modify= 'মন্তব্য শুধৰণী';
                                            } else {
                                                $modify= 'বিবিধ শুধৰণী';
                                            }
                                            ?>
                                        You are Going to Correct Legacy Data Modification / Updations for  <kbd><?php echo $modify; ?></kbd>
                                    </label>
                                </div>
                                
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button type="submit" class="btn btn-success" ><i class='fa fa-check'></i>&nbsp;Go For Correction</button>
                                    <a href="<?php echo base_url() . "index.php/LegacyDataUpdation/reject?proposal_no=" . $Pcases->proposal_no . "&case_id=" . $Pcases->case_no; ?>" class="btn btn-danger">
                                        <i class="fa fa-times"></i>&nbsp; Reject For Inadequate  Documents
                                    </a>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





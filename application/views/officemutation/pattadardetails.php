
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Mutation Seller Name ( On Behalf Of / In Place Of ) Details</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            ( On Behalf Of / In Place Of ) Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . "index.php/coofficemutation/SaveReAlongInplaceDetails"; ?>" method="post">
                        <h2 class="red">Pattadar (On Behalf Of / In Place Of) Details.</h2>
                        <div id="itemRowsPattadars">
                            <label class="rasid">Pattadar Name : </label>
                            <label>
                                <select type="text" class="form-control" name="pdar_name[]" required>
                                    <option selected><?php echo $this->lang->line('select_pattadar') ?></option>
                                    <?php 
                                    foreach ($pattadar_details as $pattadar): ?>
                                        <option value='<?php echo $pattadar->pdar_id; ?>'><?php echo $pattadar->pdar_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php
                                $pdarselect = '<select type="text" class="form-control" name="pdar_name[]" required><option selected>Select Pattadars</option>';?>
                                <?php foreach ($pattadar_details as $pattadar): 
                                $pdarselect = $pdarselect.'<option value="'.$pattadar->pdar_id.'">'.$pattadar->pdar_name.'</option>';
                                endforeach;
                                $pdarselect = $pdarselect.'</select>';
                                ?>
                            </label>
                            <label class="rasid">Inplace Alongwith : </label>
                            <label>
                                <select class="form-control inplace" name="striked_out[]" required>
                                    <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith') ?></option>
                                    <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                                    <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
                                </select>
                                <?php
                                $In_along = '<select type="text" class="form-control" name="striked_out[]" required><option selected>Select Inplace Alongwith</option>';
                                $In_along = $In_along.'<option value="1">Inplace</option>';
                                $In_along = $In_along.'<option value="0">Alongwith</option>';
                                $In_along = $In_along.'</select>';
                                ?>
                            </label>  
                            <label class="rasid"><input onclick="addRowPattadars(this.form);" type="button" class="btn btn-info" value="Add More" /></label>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                            <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $dag_details->dist_code; ?>" readonly>
                            <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $dag_details->subdiv_code; ?>" readonly>
                            <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $dag_details->cir_code; ?>" readonly>
                            <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $dag_details->mouza_pargona_code; ?>" readonly>
                            <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $dag_details->lot_no; ?>" readonly>
                            <input type="hidden" class="form-control" id="village" value="<?php echo $dag_details->vill_townprt_code; ?>" readonly>
                            <input type="hidden" class="form-control" name="case_no" value="<?php echo $case_no; ?>" readonly>
                            <input type="hidden" class="form-control" name="petition_no" value="<?php echo $petition_no; ?>" readonly>
                            </form>
                            <center>
                                <div class="col-lg-8 col-lg-offset-2">
                                    <button type="submit" id='formsubmit'  class="btn btn-success"><i class='fa fa-check'></i> Submit & Register</button>
                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">    
    $('#formsubmit').click(function() {
        document.getElementById("myForm").submit();
    });
</script>
<script>
    var rowNum1 = 0;
    function addRowPattadars(frm) {
        rowNum1++;
        var pdarselect = '<?php echo $pdarselect;?>';
        var In_along = '<?php echo $In_along; ?>';
        var row = '<div class="dynamic-row" class="center" id="rowNum1' + rowNum1 + '"><label class="rasid">Pattadar Name : </label> <label>' + pdarselect + '</label> <label class="rasid">Inplace Alongwith :</label> <label>' + In_along + '</label> <label class="rasid"><input type="button" class="btn btn-danger" value=" Remove&nbsp;" onclick="removeRowPattadars(' + rowNum1 + ');"></div>';
        jQuery('#itemRowsPattadars').append(row);
        frm.pdar_name.value = '';
        frm.striked_out.value = '';
    }
   function removeRowPattadars(rnum) {
        jQuery('#rowNum1' + rnum).remove();
    }
</script>




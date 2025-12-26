
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Mutation ( Back Log Entry )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Add Applicants Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . "index.php/BackLogMutation/RegisterOMutation"; ?>" method="post">
                        <div id="itemRows">
                        <label class="rasid">Applicants Name : </label><label><input type="text" class="form-control" name="applicant_name[]" /></label>
                        <label class="rasid">Guardian : </label><label><input type="text" class="form-control" name="guardian[]" /></label> 
                        <label class="rasid">Address : </label><label><input type="text" name="add_1[]" class="form-control" /></label> 
                        <label class="rasid"><input onclick="addRow(this.form);" type="button" class="btn btn-info" value="Add More" /></label>
                        <label class="rasid">Individual Share  &nbsp;:</label>&nbsp;<label><input type="text" name="inv_b[]" class="form-control" placeholder="0 Bigha" /></label>
                        <label><input type="text" name="inv_k[]" class="form-control" placeholder="0 Katha" /></label>
                        <label><input type="text" name="inv_lc[]" class="form-control"  placeholder="0 Lesa" /></label><label class="rasid">(if Known)</label>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2 class="red">Pattadar (On Behalf Of / In Place Of) Details.</h2>
                        <div id="itemRowsPattadars">
                            <label class="rasid">Pattadar Name : </label>
                            <label>
                                <select type="text" class="form-control" name="pdar_name[]" required>
                                    <option selected><?php echo $this->lang->line('select_pattadar') ?></option>
                                    <?php foreach ($pattadar_details as $pattadar): ?>
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
                            <h2 class="center red bold"><u>Please select the name who passes this order </u></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name') ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="lm_code" id="lm_code">
                                    <option selected disabled value="">Select Lot Mondal</option>
                                    <?php
                                    foreach($lmname as $lm){
                                    ?>
                                       <option value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">Mondal Signed </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text">Signed Date </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup3Datepicker" name="lm_date" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sk_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="sk_code">
                                    <option selected disabled value="">Select SK</option>
                                    <?php
                                    foreach($skname as $sk){
                                    ?>
                                       <option  value="<?php echo $sk->user_code;?>"><?php echo $sk->username;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">SK Signed </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text">SK Signed Date </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup2Datepicker" name="sk_date" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="co_code" id="co_code">
                                    <option selected disabled value="">Select Circle Officer</option>
                                    <?php
                                    foreach($coname as $co){
                                    ?>
                                       <option value="<?php echo $co->user_code;?>"><?php echo $co->username;?></option>
                                    <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">CO Signed </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text">CO Signed Date </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" name="co_date" class="form-control"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12" id="co_block">
                                    <label class="rasid col-sm-12">
                                          <input type="checkbox" id="myCheck" onclick="myFunction()"> লাঃ মঃ - চিঠা নথি তথ্য অনুসৰি এই দাগৰ নামজাৰী সবিশেষ বকেয়া অন্তৰ্ভূক্তিৰ বাবে চক্ৰ বিষয়াৰ অনুমোদন বিচৰা হ’ল |
                                    </label>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $location['dist_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $location['subdiv_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $location['cir_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $location['mouza_pargona_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $location['lot_no']; ?>" readonly>
                            <input type="hidden" class="form-control" id="village" value="<?php echo $location['vill_code']; ?>" readonly>
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
        //var applicant_name = $('#ap').val();
        var lm_code = $('#lm_code').val();
        var co_code = $('#co_code').val();
        //var pattadar_exist = $('#pattadar_exist').val();
        //alert(applicant_name);
        
        if((lm_code == null) || (co_code == null)){
            alert('Please Enter Lot Mondal & Circle Officer Details!');
            return false;
        }
        document.getElementById("myForm").submit();
    });
    
    $("#formsubmit").attr('disabled', true);
    function myFunction() {
       var checkBox = document.getElementById("myCheck");
       if (checkBox.checked == true){
         $('#formsubmit').removeAttr('disabled', false);
       } else {
         $('#formsubmit').attr('disabled', true);
       }
   }   
</script>
<script>
    var rowNum = 0;
    function addRow(frm) {
        rowNum++;
        var row = '<div class="dynamic-row" class="center" id="rowNum' + rowNum + '"><label class="rasid">Applicants Name : </label><label><input type="text" class="form-control" name="applicant_name[]"  value=""></label> <label class="rasid">Guardian :</label><label><input type="text" class="form-control" name="guardian[]" value=""></label> <label class="rasid">Address :</label><label><input type="text" class="form-control" name="add_1[]" value=""></label> <label class="rasid"><input type="button" class="btn btn-danger" value=" Remove&nbsp;" onclick="removeRow(' + rowNum + ');"></label><label class="rasid">Individual Share  &nbsp;:</label>&nbsp;<label><input type="text" name="inv_b[]" class="form-control" placeholder="0 Bigha" /></label><label><input type="text" name="inv_k[]" class="form-control" placeholder="0 Katha" /></label><label><input type="text" name="inv_lc[]" class="form-control"  placeholder="0 Lesa" /></label><label class="rasid">(if Known)</label></div>';
        jQuery('#itemRows').append(row);
        frm.applicant_name.value = '';
        frm.guardian.value = '';
        frm.add_1.value = '';
    }
   function removeRow(rnum) {
        jQuery('#rowNum' + rnum).remove();
    }
    
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




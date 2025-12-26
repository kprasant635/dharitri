
<div class="container-fluid login form-top">
        
   
        <div class="col-lg-6 col-lg-offset-2">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm">
                <h2 style="text-align: center;">Change Jamabandi Status For Re Updation</h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url()."index.php/Maintenance/JamabandiStatus";?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select  class="form-control districtselect" id="dist" name="dist_code" required>
                                    <?php $dist_code = $this->session->userdata('dist_code'); ?>
                                    <option value="<?php echo $dist_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                                    </option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-9">
                                <select  class="form-control subdivselect" id="subdiv" name="subdiv_code" required>
                                    <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                                    <option value="<?php echo $subdiv_code; ?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-9">
                                <select class="form-control circleselect" id="circ" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselect" id="mouza" name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                    <?php foreach ($mouza as $moz): ?>
                                        <?php
                                        $mouza_code = $moz->mouza_pargona_code;
                                        $mouza_name = $moz->loc_name;
                                        ?>
                                        <option value="<?php echo $mouza_code; ?>"><?php echo $mouza_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselect" id="lot" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselect" id="vill" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_type') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control pattatype_nmae" id="patta_type" required name="patta_type">
                                    <option selected disabled>Select Patta Type</option>
                                    <?php foreach ($patta_types as $pt): ?>
                                        <option value="<?php echo $pt->type_code; ?>"><?php echo $pt->patta_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-lg-3 control-label"><?php echo $this->lang->line('patta_no') ?></label>
                            <div class="col-lg-9">
                                <select class="form-control pattanoselect" name="patta_no">
                                    <option>Select Patta Number</option>
                                </select>
                            </div>
                        </div>
                        <div class='msg' style="display: none;"></div>
                        <label class="alert alert-success  rasid col-sm-12">
                              <input type="checkbox" id="myCheck" onclick="myFunction()">   স্বীকাৰোক্তিঃ Change Jamabandi Status For Re Updation.   
                        </label>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="Submit" class="btn btn-success"  id="change_text1"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="Submit" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/Maintenance/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    
</div>
<script type="text/javascript">
    $("#change_text1").attr('disabled', true);
    $(".pattanoselect").change(function () {
        var patta_type_code = $('#patta_type').val();
        var dist_code_new = $('#dist').val();
        var subdiv_code_new = $('#subdiv').val();
        var circle_code_new = $('#circ').val();
        var mouza_code_new = $('#mouza').val();
        var lot_no_new = $('#lot').val();
        var village_new = $('#vill').val();
        var patta_no = $(this).val();
        $.ajax({
            url: baseurl + "Maintenance/ExistingDagNo/" + patta_no + "/" + patta_type_code + "/" + dist_code_new + "/" + subdiv_code_new + "/" + circle_code_new + "/" + mouza_code_new + "/" + lot_no_new + "/" + village_new,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var data = JSON.parse(data);
                if (data['val'] == '') {
                    $(".msg").show();
                    var template = "<label class='red'>এই পট্টাত কোনো দাগ নাই |</label>";
                    $("#change_text1").attr('disabled', true);
                    $(".msg").html(template);
                }
                if (data['val'] != '') {
                    $(".msg").show();
                    var template = "<label class='red'>"+data['val']+"</label>";
                    $(".msg").html(template);
                }

            }
        });
    });
    
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  if (checkBox.checked == true){
    $('#change_text1').removeAttr('disabled', false);
  } else {
    $('#change_text1').attr('disabled', true);
  }
}
</script>
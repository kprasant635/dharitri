
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('reclassification_case_registration_form_back_log'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('select_location') ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>Note: This process is entering data directly into the Chitha. Please make sure your are entering the correct data.You are responsible for this entry.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('location_details'); ?></mark></h2>
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/Utility/BackEntryLandReclassificationSubmit1"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" readonly id="select" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" readonly id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" readonly id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option><?php echo $this->lang->line('select_mouza'); ?></option>
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
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected>Select Lot No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected>Select Village/Town</option>
                                    </select>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><b>NOTE : Please Insert the Dag Number and click the "Generate Dag Details" button. It will Auto Generate All The Details. If it doesn't than click the "Generate Dag Details" button again.</h6>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control g_from_d" id="g_from_d" placeholder="Dag No" name="dag_no" autocomplete="off">
                                </div>
                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-success btn-block" value="Generate Dag Details" onclick="generate_dag()">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control patta" id="patta" placeholder="Patta No" name="patta_no" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="patta_type">
                                        <option selected disabled><?php echo $this->lang->line('select_patta_type'); ?></option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="land_class">
                                        <option selected disabled><?php echo $this->lang->line('select_land_class'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control p_land_revv" id="p_land_revv" placeholder="" name="land_rev" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control loc_tax" id="loc_tax" placeholder="" name="loc_tax" readonly>
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('total_revenue'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control tot_rev" id="tot_rev" placeholder="" name="tot_rev" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('year_in_which_the_land_is_used_for_other_purpose'); ?></label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control"  placeholder="Like : 2017" name="new_landuse_year" required> 
                                </div>
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp ( Example : 2017 )</label>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group alert alert-success">
                                <label for="inputEmail3" class="col-sm-4 control-label"><span class="ass-btn" style="line-height: 50px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?><?php echo $this->lang->line('land_area'); ?></span></label>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                    <input type="text" class="form-control" id='b' name='dag_area_b' placeholder="বিঘা" readonly>
                                </div>

                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                    <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="Katha" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                    <input type="text" class="form-control"  id='l' name='dag_area_lc' placeholder="Lessa" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group col-lg-12">
                                <label for="inputEmail3" class="col-sm-3 control-label">Select Land Class Type</label>
                                <div class="radio-inline col-sm-6" >
                                    <label class="col-sm-3"><input type="radio" class="squaredTwo" id="agri" name="optradio">   Agri</label>
                                    <label class="col-sm-3"><input type="radio" class="squaredTwo" id="nonagri" name="optradio">  Non-Agri</label>
                                </div>
                            </div>
                            <div class="form-group agri" style="display: none">
                                <label for="inputEmail3" class="col-sm-3 control-label">New Agricultural land</label>
                                <div class="col-sm-3">
                                    <select name="new_land_class" class="form-control">
                                        <option value="" disabled selected>-- Select --</option>
                                        <?php foreach ($land_class_agri as $lnd_cls_agri): ?>
                                            <option value="<?php echo $lnd_cls_agri->class_code; ?>"><?php echo $lnd_cls_agri->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group nonagri" style="display: none">
                                <label for="inputEmail3" class="col-sm-3 control-label">New Non Agricultural land</label>
                                <div class="col-sm-3">
                                    <select name="new_land_class" class="form-control">
                                        <option value="" disabled selected>-- Select --</option>
                                        <?php foreach ($land_class_non_agri as $lnd_cls_non_agri): ?>
                                            <option value="<?php echo $lnd_cls_non_agri->class_code; ?>"><?php echo $lnd_cls_non_agri->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="P_land" placeholder="Revenue" name="P_land_rev">
                                </div>
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="p_loc_tax" placeholder="" name="p_local_tax" readonly>
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('revenue_difference'); ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="rev_diff" placeholder="Difference" name="Rev_diff" readonly>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('case_details'); ?></mark></h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control villageselect" placeholder="Enter Case Number"  required name="case_no" />
                                </div>
                                <label class="col-lg-2 control-label uni_text">Date of order </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required=""  name="order_date"  class="form-control"  >
                                </div>
                                <label class="col-lg-2 control-label uni_text">Year Number </label>
                                <div class="col-lg-2">
                                    <input type="text" required=""  name="year_no"  class="form-control"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="center red bold"><u>Please select the name who passes this order </u></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name') ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="lm_code">
                                    <option selected disabled>Select Lot Mondal</option>
                                    <?php
                                    foreach($lmname as $lm){
                                    ?>
                                       <option  value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup3Datepicker" required=""  name="lm_date"  class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('dc_adc_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="dc_code">
                                    <option selected disabled>Select DC / ADC</option>
                                    <?php
                                    foreach($dc_adc as $dcadc){
                                    ?>
                                       <option  value="<?php echo $dcadc->user_code;?>"><?php echo $dcadc->username;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="dcSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="dcSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup2Datepicker" required=""  name="dc_date"  class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control"  required name="co_code">
                                    <option selected disabled>Select Circle Officer</option>
                                    <?php
                                    foreach($coname as $co){
                                    ?>
                                       <option value="<?php echo $co->user_code;?>"><?php echo $co->username;?></option>
                                    <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" required=""  name="co_date"  class="form-control"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#agri").click(function () {
            $(".agri").show();
            $(".nonagri").hide();
        });
        $("#nonagri").click(function () {
            $(".agri").hide();
            $(".nonagri").show();
        });
    });
    function generate_dag() {
        var dag_no = $('#g_from_d').val();
        var mouzaselect = $('.mouzaselect').val();
        var lotselect = $('.lotselect').val();
        var villageselect = $('.villageselect').val();
        if (dag_no == '')
        {
            alert("Please Enter a Dag No..");
            exit();
        }
        $.ajax({
            url: baseurl + "LandReclassification/getDagDetJSONForBacklog/" + dag_no + '/' + mouzaselect + '/' + lotselect + '/' + villageselect,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }

                var dag = JSON.parse(data);
                $('#patta').val(dag[0].patta_no);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(parseFloat(dag[0].dag_area_lc));
                $('#g').val(parseFloat(dag[0].dag_area_g));
                $('#k').val(dag[0].dag_area_kr);
                //$('#Patta_type').val(dag[0].patta_type_code);
                //$('#land_class').val(dag[0].land_class_code);
                var land_rev = dag[0].dag_revenue;
                var l_tax = dag[0].dag_local_tax;
                var total = parseFloat(land_rev) + parseFloat(l_tax);
                $('#p_land_revv').val(parseFloat(land_rev).toFixed(2));
                $('#loc_tax').val(parseFloat(l_tax).toFixed(2));
                $('#tot_rev').val(parseFloat(total).toFixed(2));
                var patta_code = dag[0].patta_type_code;
                //alert(patta_code);
                $.ajax({
                    url: baseurl + "LandReclassification/getPattaNameJSON/" + patta_code,
                    success: function (data) {
                        if (debug) {
                            console.log(data);
                        }
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Patta Type</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += "<option value='" + lot[i].type_code + "' selected>" + lot[i].patta_type + "</option>";
                        }
                        console.log(template);
                        $('select[name="patta_type"]').html(template);
                    }
                });

                var land_class_code = dag[0].land_class_code;
                $.ajax({
                    url: baseurl + "LandReclassification/getLandClassNameJSON/" + land_class_code,
                    success: function (data) {
                        if (debug) {
                            console.log(data);
                        }
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Land Class</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += "<option value='" + lot[i].class_code + "' selected>" + lot[i].land_type + "</option>";
                        }
                        console.log(template);
                        $('select[name="land_class"]').html(template);
                    }
                });

            }
        });
    }
</script>
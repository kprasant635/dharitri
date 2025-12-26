
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('conversion_case_registration_form_back_log'); ?></h2>
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
                            <h6 class="red uni_text"><b>Note: This process is entering data directly into the Chitha. Please make sure your are entering the correct data.You  are responsible for this entry.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('location_details'); ?></mark></h2>
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url() . "index.php/Utility/BackEntryLandConversionSubmit1"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" readonly id="dist_code_new" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div> 
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" readonly id="subdiv_code_new" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" readonly id="circle_code_new" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="mouza_code_new" required name="mouza_code">
                                        <option disabled selected value=""><?php echo $this->lang->line('select_mouza'); ?></option>
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
                                    <select class="form-control lotselect" id="lot_no_new" required name="lot_no">
                                        <option disabled selected  value="">Select Lot No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="village" required name="vill_code">
                                        <option disabled selected  value="">Select Village/Town</option>
                                    </select>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('dag_details'); ?></mark></h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control pattatype_nmae" id="new_patta_type" name="patta_code" required >
                                        <option disabled selected value="">Select Patta Type</option>
                                        <?php
                                        foreach ($pattatype as $p) {
                                            ?>
                                            <option  value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                        <option disabled selected value="">Select Patta No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                        <option disabled selected value=""><?php echo $this->lang->line('select_dag_no'); ?></option>
                                    </select>
                                </div>

                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('land_details'); ?></mark></h2>
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text"><b>Please Tick ( <span class="glyphicon glyphicon-ok" aria-hidden="true" style='color: green;'></span> ) on the Check Box  in case of a Full Land Conversion or Please enter the Land Area to be mutated below.</b></h6>
                                <label for="inputEmail3" class="col-sm-8 control-label" style="color: #990000; top:-10px"><?php echo $this->lang->line('tick_if_whole_land_conversion'); ?> </label>
                                <input type="checkbox" id="PartialOrFull" name="PartialOrFull" value="Y"/>
                            </div>
                            
                            <!--during partial conversion-->
                            <div id="autoUpdate1" class="autoUpdate">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" class="form-control" id='b' name='dag_area_b' placeholder="বিঘা" readonly>
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="কঠা" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" class="form-control"  id='l' name='dag_area_lc' placeholder="লেছা" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('type_converted_land_area'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" maxlength="6" class="form-control" id='mb' name='m_dag_area_b_P' value="0" placeholder="বিঘা" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" maxlength="6" class="form-control" name='m_dag_area_k_P' id='mutatedk' value="0"  placeholder="কঠা" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" maxlength="6" class="form-control" name='m_dag_area_lc_P' id='lm' value="0" placeholder="লেছা" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('remaining_part_of_the_dag'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" class="form-control" id="rb" name='l_dag_area_b_P' placeholder="বিঘা" value="0" readonly>
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" class="form-control" id="rkatha" name='l_dag_area_k_P' placeholder="কঠা" value="0" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" class="form-control" id="rl" name='l_dag_area_lc_P' placeholder="লেছা" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                            <!--end of partial conversion-->


                            <!--during full conversion-->
                            <div id="autoUpdate2" class="autoUpdate" style="display: none;">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" class="form-control" id='b1' name='dag_area_b' value="0" placeholder="বিঘা" readonly>
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" class="form-control"  id='katha1' name='dag_area_k' value="0" placeholder="কঠা" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" class="form-control"  id='l1' name='dag_area_lc' value="0" placeholder="লেছা" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('petitioner_part_of_the_dag'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" class="form-control" id='b2' name='m_dag_area_b' value="0" placeholder="বিঘা" readonly>
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" class="form-control"  id='katha2' name='m_dag_area_k' value="0" placeholder="কঠা" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" class="form-control"  id='l2' name='m_dag_area_lc' value="0" placeholder="লেছা" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;"><?php echo $this->lang->line('remaining_part_of_the_dag'); ?></label>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                        <input type="text" class="form-control" name='l_dag_area_b' placeholder="বিঘা" readonly value="0">
                                    </div>

                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                        <input type="text" class="form-control"   name='l_dag_area_k' placeholder="কঠা" readonly value="0">
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                        <input type="text" class="form-control"   name='l_dag_area_lc' placeholder="লেছা" readonly value="0">
                                    </div>
                                </div>
                            </div>
                            <!--end of full conversion-->
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('case_details'); ?></mark></h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-4">
                                    <input class="form-control" id="case_no" placeholder="Enter Case Number"  required name="case_no" />
                                    <div id="msg1"></div>
                                </div>
                                <label class="col-lg-2 control-label uni_text">Order Date</label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required name="order_date"  class="form-control">
                                </div>
                                <label class="col-lg-1 control-label uni_text">Year</label>
                                <div class="col-lg-1">
                                    <input type="text" required=""  name="year_no"  class="form-control" required>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" name="ASTSTEP2Submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#backlog_patta_type").change(function (e) {
        //alert('sda');
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $(this).val();
        //alert(distcode+" "+subdivcode+" "+circode+" "+mouzacode+" "+lotcode+" "+villcode+" "+patta_type_code);
        $.ajax({
            url: baseurl + "Utility/getDagsbacklog/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no,
            success: function (d) {
                var object = JSON.parse(d);
                //alert (object[i].dag_no_int);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {

                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });
    
    $(document).ready(function () {
        $('#PartialOrFull').change(function () {
            if (!this.checked)
            {
                //alert("not checked");
                $('#autoUpdate1').show();
                $('#autoUpdate2').hide();
            }
            else
            {
                //alert("clicked");
                $('#autoUpdate1').hide();
                $('#autoUpdate2').show();
            }
        });
    });
    
    $('.get_dag_no_sara').change(function (e) {
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $('.pattanoselect').val();
        var dag_no = $(this).val();
        //alert(dag_no);
        $.ajax({
            url: baseurl + "Utility/getLandAreaJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no + "/" + dag_no,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var dag = JSON.parse(data);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(dag[0].dag_area_lc);
                $('#g').val(dag[0].dag_area_g);
                $('#k').val(dag[0].dag_area_kr);
                $('#b1').val(dag[0].dag_area_b);
                $('#katha1').val(dag[0].dag_area_k);
                $('#l1').val(dag[0].dag_area_lc);
                $('#g1').val(dag[0].dag_area_g);
                $('#k1').val(dag[0].dag_area_kr);
                $('#b2').val(dag[0].dag_area_b);
                $('#katha2').val(dag[0].dag_area_k);
                $('#l2').val(dag[0].dag_area_lc);
                $('#g2').val(dag[0].dag_area_g);
                $('#k2').val(dag[0].dag_area_kr);
                $('#dag_rev').val(dag[0].dag_revenue);
                $.ajax({
                    url: baseurl + "lmmutation/getMutatedLandAreaJSON",
                    success: function (data) {
                        console.log(data);
                        var dag = JSON.parse(data);
                        $('#mb').val(dag[0].bigha);
                        $('#mutatedk').val(dag[0].katha);
                        $('#lm').val(dag[0].lessa);
                        $('#mg').val(0);
                        $('#mk').val(0);
                        $('#rb').val(0);
                        $('#rkatha').val(0);
                        $('#rl').val(0);
                        calculateRemainingLand();
                    }
                });

            }
        });
    });
    
    $('#case_no').keyup(function () {
        var case_no = $('#case_no').val();
        //var case_no = encodeURIComponent(encodeURIComponent(case_no));
        $.ajax({
            type: "GET",
            url: baseurl + "COconversionPartha/chech_case_no_exist",
            data: ({case_no:case_no}),
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result == '1')
                {
                    document.getElementById("msg1").style.display = "block";
                    document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"control-label\"><p style=\" color: #ff0000; align:center\">Case No Exists</p></label>";
                } else {
                    document.getElementById("msg1").style.display = "none";
                }
            }
        });
    });
    
    $('#formsubmit').click(function() {
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village').val();
        if((dist_code_new == null) || (subdiv_code_new == null) || (circle_code_new == null) || (mouza_code_new == null) || (lot_no_new == null) || (village_new == null)){
            alert('Please Select Location Details!');
            return false;
        }
        var new_dag = $('#dag_no').val();
        var new_patta = $('#backlog_patta_type').val();
        var new_patta_type = $('#new_patta_type').val();
        if((new_dag == null) || (new_patta == null) || (new_patta_type == null)){
            alert('Please Enter Land Details!');
            return false;
        }
        if(document.getElementById('PartialOrFull').checked == false){
            var lessa_empty = $('#lm').val();
            var kotha_empty = $('#mutatedk').val();
            var bigha_empty = $('#mb').val();
            if ((lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
                alert('Bigha-Katha-lessa for conversion cannot be 0-0-0 !');
                return false;
            }
        }
        var case_no = $('#case_no').val();
        //var case_no = encodeURIComponent(encodeURIComponent(case_no));
        //return false;
        $.ajax({
            type: "GET",
            url: baseurl + "COconversionPartha/chech_case_no_exist",
            data: ({case_no:case_no}),
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result == '1')
                {
                    document.getElementById("msg1").style.display = "block";
                    document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"control-label\"><p style=\" color: #ff0000; align:center\">Case No Exists</p></label>";
                    return false;
                }
                else
                {
                    document.getElementById("myForm").submit();
                    return false;
                }
            }
        });
    });
</script>
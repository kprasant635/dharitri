
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Conversion ( Back Log Entry )</h2>
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
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url() . "index.php/BackLogConversion/BackLogRegister"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control districtselect" id="dist_code_new" name="dist_code" >
                                    <?php $dist_code=$this->session->userdata('dist_code');?>
                                    <option value="<?php echo $dist_code;?>"  selected>
                                        <?php echo $this->utilityclass->getDistrictName($dist_code);?>
                                    </option>
                                </select>
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control subdivselect" id="subdiv_code_new" name="subdiv_code" >
                                    <?php $subdiv_code=$this->session->userdata('subdiv_code');?>
                                    <option value="<?php echo $subdiv_code;?>"  selected>
                                        <?php echo $this->utilityclass->getSubDivName($dist_code,$subdiv_code);?>
                                    </option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control circleselect" id="circle_code_new"  name="circle_code">
                                    <?php $cir_code=$this->session->userdata('cir_code');?>
                                    <option value="<?php echo $cir_code;?>"  selected>
                                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$cir_code);?>
                                    </option>
                                </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="mouza_code_new"  name="mouza_code">
                                    <?php $mouza_code=$this->session->userdata('mouza_pargona_code');?>
                                    <option value="<?php echo $mouza_code;?>"  selected>
                                        <?php echo $this->utilityclass->getMouzaName($dist_code,$subdiv_code,$cir_code,$mouza_code);?>
                                    </option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="lot_no_new"  name="lot_no">
                                    <?php 
                                    $lot_no=$this->session->userdata('lot_no');
                                    $lot_name=$this->utilityclass->getLotLocationName($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no);
                                    ?>
                                    <option value="<?php echo $lot_no;?>"  selected>
                                        <?php echo $lot_name;?>
                                    </option>
                                </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="village"  name="vill_code">
                                    <option disabled selected><?php echo $this->lang->line('select')?></option>
                                    <?php foreach($villages as $d):?>
                                    <option value='<?php echo $d->vill_townprt_code;?>'><?php echo $d->loc_name;?></option>
                                    <?php endforeach;?>
                                </select>
                                </div>
                            </div>  
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red"><?php echo $this->lang->line('dag_details'); ?>  as per Conversion order Passed</h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control pattatype_nmae" id="new_patta_type" required name="patta_type">
                                       <option selected disabled><?php  echo $this->lang->line('select_patta_type'); ?></option>
                                           <?php foreach ($patta_type_only_aksona as $p): ?>
                                               <option value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                           <?php endforeach; ?>
                                   </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                        <option disabled selected value="">Select Patta No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                        <option disabled selected value=""><?php echo $this->lang->line('select_dag_no'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div id="msg2"></div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red"><?php echo $this->lang->line('land_details'); ?> as per Conversion order Passed</h2>
                            <!--Actual Land Area-->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;">Total Land Area</label>
                                <div class="col-sm-3">
                                    <p class="center bold">বিঘা</p>
                                    <input type="number"  class="form-control" value="0" readonly="" id='b' name='dag_area_b' placeholder="বিঘা">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold">কঠা</p>
                                    <input type="number"  class="form-control" value="0"  readonly="" id='katha' name='dag_area_k' placeholder="কঠা">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold">লেছা</p>
                                    <input type="number"  class="form-control"  readonly="" id='l' name='dag_area_lc' placeholder="লেছা" value="0">
                                </div>
                            </div>
                            <!--Land Area To Be Mutated-->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;">Converted Land Area</label>
                                <div class="col-sm-3">
                                    <p class="center bold">বিঘা</p>
                                    <input type="number" maxlength="6" class="form-control" value="0" id='mb' name='m_dag_area_b' placeholder="বিঘা">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold">কঠা</p>
                                    <input type="number" maxlength="2" class="form-control" value="0" name='m_dag_area_k' id='mutatedk'  placeholder="কঠা">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold">লেছা</p>
                                    <input type="number" maxlength="7" class="form-control" value="0" name='m_dag_area_lc' id='lm' placeholder="লেছা">
                                </div>
                            </div>
                            <!--Remaining Land Area-->
                            <div class="form-group hide">
                                <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;">Remaining Land Area</label>
                                <div class="col-sm-3">
                                    <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                    <input type="number" class="form-control" readonly="" id="rb" name="l_dag_area_b_P" placeholder="বিঘা" value="0">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                    <input type="number" class="form-control" readonly="" id="rkatha" name="l_dag_area_k_P" placeholder="কঠা" value="0">
                                </div>
                                <div class="col-sm-3">
                                    <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                    <input type="number" class="form-control" readonly="" id="rl" name="l_dag_area_lc_P" placeholder="লেছা" value="0">
                                </div>
                            </div>
                            
                            
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red"><?php echo $this->lang->line('case_details'); ?>  as per Conversion order Passed</h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Conversion Type</label>
                                <div class="col-lg-3">
                                    <select class="form-control inplace" id = "FullOrPartial" name="FullOrPartial" required>
                                        <option selected disabled>Select Conversion Type</option>
                                        <option value="F">Full Conversion</option>
                                        <option value="P">Partial Conversion</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Passed <?php echo $this->lang->line('case_no'); ?></label>
                                <div class="col-lg-3">
                                    <input class="form-control" id="case_no" placeholder="Enter Case Number"  required name="case_no" />
                                    <div id="msg1"></div>
                                </div>
                                <label class="col-lg-2 control-label uni_text">Order Date</label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup5Datepicker" required name="order_date" class="form-control">
                                </div>
                                <label class="col-lg-1 control-label uni_text">Year</label>
                                <div class="col-lg-1">
                                    <input type="text" required="" id = "year_no"  name="year_no"  class="form-control" required>
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
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $(this).val();
        $.ajax({
            url: baseurl + "Utility/getDagsbacklog/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no,
            success: function (d) {
                var object = JSON.parse(d);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {

                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
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
        $.ajax({
            url: baseurl + "Utility/getLandAreaJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no + "/" + dag_no,
            success: function (data) {
               
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
        
        $.ajax({
            url: baseurl + "BackLogConversion/chech_if_already_registered/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_no + "/" + dag_no +"/" + patta_type_code,
            success: function (data) {
               
                var result = JSON.parse(data);
                if(result == '1')
                {
                    document.getElementById("msg2").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Note : Conversion Case Already regisered for the above Dag No..</p></label>";
                } else {
                    document.getElementById("msg2").style.display = "none";
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
            alert('Please Enter Dag Details!');
            return false;
        }
        
        var lessa_empty = $('#lm').val();
        var kotha_empty = $('#mutatedk').val();
        var bigha_empty = $('#mb').val();
//        if ((lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
//            alert('Please Enter Mutated Land Area  !');
//            return false;
//        }
        
        var year_no = $('#year_no').val();
        if (year_no == null) {
            alert('Please Enter Year !');
            return false;
        }
        
        var case_no = $('#case_no').val();
        
        $.ajax({
            type: "GET",
            url: baseurl + "BackLogConversion/check_case_no_exist",
            data: ({case_no:case_no}),
            success: function (data) {
               
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

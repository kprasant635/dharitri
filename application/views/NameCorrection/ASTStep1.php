<script type="text/javascript">
    function check() {
        var cnt = $("input[type=checkbox]:checked").length;
        if (cnt < 2) {
            alert("You sholud select atleast two documents.");
            return false;
        }
        return true;
    }

    function onlyint(patta) {
        //alert(patta);
        if (patta.length > 0) {
            var regex = /^[0-9]{1,10}$/;
            if (regex.test(patta)) {
                return true;
            }
            else {
                document.f1.patta_no.value = "";
                alert('Only numeric values');
                return false;
            }
        }
    }

</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('registration_form_for_name_correction'); ?> </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pattadar_name_correction'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form name="f1" class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="case_type" value="06"/>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label "><?php echo $this->lang->line('order_date'); ?>*</label>
                                <div class="col-lg-3">
                                    <input type="text" id="popupDatepicker" class="form-control" name="ord_date" value="<?php echo date('d-m-Y') ?>" >
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('address_to_the_officer'); ?> </label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="official" >
                                        <option selected disabled><?php echo $this->lang->line('address_to_the_officer'); ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u['user_code']; ?>"><?php echo $u['co_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('select_land_location'); ?></mark></h2>
                            <hr/>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-3">
                                    <input type="hidden" name="dist_code" class="districtselect" value="<?php echo $this->session->userdata('dist_code'); ?>"/>
                                    <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $dist[0]->district; ?>"/>
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('subdivision'); ?> </label>
                                <div class="col-lg-3">
                                    <input type="hidden" name="subdiv_code" class="subdivselect" value="<?php echo $this->session->userdata('subdiv_code') ?>"/>
                                    <input type="text" name="subd" class="form-control " readonly="readonly" value="<?php echo $subdiv[0]->subdiv; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-3">
                                    <input type="hidden" name="cir_code" class="circleselect" value="<?php echo $this->session->userdata('cir_code') ?>"/>
                                    <input type="text" name="cir" class="form-control " readonly="readonly" value="<?php echo $circle[0]->circle; ?>"/>
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option disabled selected><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouzalist AS $m) { ?>
                                            <option value="<?php echo $m->mouza_code; ?>"><?php echo $m->mouza; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                                <div class="col-lg-3">
                                    <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected><?php echo $this->lang->line('select_lot_no'); ?></option>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town'); ?> </label>
                                <div class="col-lg-3">
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected><?php echo $this->lang->line('select_vill_town'); ?> </option>
                                    </select>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark><?php echo $this->lang->line('select_patta_information'); ?></mark></h2>
                            <hr/>
                            
                            <!-------------------->
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control pattatype_nmae" name="patta_type_code" required >
                                        <option value="" selected><?php echo $this->lang->line('select_patta_type');?></option>
                                        <?php foreach ($patta AS $patta) { ?>
                                            <option value="<?php echo $patta->type_code; ?>"><?php echo $patta->patta_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                        <option>Select Patta No</option>
                                    </select>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-lg-2">
                                    <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                        <option><?php echo $this->lang->line('select_dag_no'); ?></option>
                                    </select>
                                </div>
                            </div><!-------------------->
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('supporting_document'); ?> </label>
                                <div class="col-lg-8">

                                    <?php foreach ($supporting_doc AS $doc) { ?>
                                    <input type="checkbox" name="doc_name[]" value="<?php echo $doc->supp_doc_code; ?>"><span class="uni_text"><?php echo $doc->supp_doc_name; ?></span> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php } ?>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
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
        $(".check_empty").keyup(function(){
            var lessa_empty = $(this).val();
            var kotha_empty = $('#mutatedk').val();
            var bigha_empty = $('#mb').val();
            if ((lessa_empty == '0') && (kotha_empty == '0') && (bigha_empty == '0')) {
                alert('Bigha-Katha-lessa for conversion cannot be 0-0-0 !');
                return;
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
</script>


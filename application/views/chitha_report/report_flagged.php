
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="col-lg-8 col-lg-offset-2">
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Chitha Display</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url() . 'index.php/chithareport/generateDagChitha' ?>">
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-9">
                                <select  class="form-control districtselectflag" id="LmMutationSelectDistrict" name="dist_code" required>
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
                                <select  class="form-control subdivselectflag" id="select" name="subdiv_code" required>
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
                                <?php
                                $d = $this->utilityclass->getAllCircleName($dist_code, $subdiv_code);
                                ?>
                                <select  class="form-control circleselectflag" id="select" required name="circle_code">
                                    <option selected disabled>Select Circle</option>
                                    <?php foreach ($d as $name) { ?>
                                        <option value="<?php echo $name->cir_code; ?>"  >
                                            <?php echo $name->loc_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('mouza')?></label>
                            <div class="col-lg-9">
                                <select class="form-control mouzaselectflag" id="select" required name="mouza_code">
                                    <option disabled selected>Select Mouza</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('lot_no')?></label>
                            <div class="col-lg-9">
                                <select class="form-control lotselectflag" id="select" name="lot_no">
                                    <option disabled selected>Select Lot No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('vill_town')?></label>
                            <div class="col-lg-9">
                                <select class="form-control villageselectflagged" id="select" name="vill_code">
                                    <option disabled selected>Select Village/Town</option>
                                </select>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
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
<script type="text/javascript">

$('.districtselectflag').change(function (e) {
        var distCode = $(this).val();
        //alert(distCode);
        console.log("aa" + baseurl);
        $.ajax({
            url: baseurl + "lmmutation/getSubdivJson/" + distCode,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                console.log(template);
                $('.subdivselectflag').html(template);
            }
        });
    });
    $('.subdivselectflag').change(function (e) {
        var subdivcode = $(this).val();
        var distcode = $('.districtselectflag').val();
        $.ajax({
            url: baseurl + "lmmutation/getCirCodeJson/" + distcode + '/' + subdivcode,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                console.log(template);
                $('.circleselectflag').html(template);
            }
        });
    });

    $('.circleselectflag').change(function (e) {
        //alert("asda");
        var subdivcode = $('.subdivselectflag').val();
        var distcode = $('.districtselectflag').val();
        var circode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getMouzaJson/" + distcode + '/' + subdivcode + '/' + circode,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                    
                // }
                var mouza = JSON.parse(data);
                console.log(mouza);
                //alert(mouza[0].loc_name);
                var template = "<option selected disabled>Select Mouza</option>";

                for (var i = 0; i < mouza.length; i++) {
                    template += "<option value='" + mouza[i].mouza_pargona_code + "'>" + mouza[i].loc_name + "</option>";
                }
                console.log(template);
                $('.mouzaselectflag').html(template);
            }
        });
    });

    $('.mouzaselectflag').change(function (e) {
        var subdivcode = $('.subdivselectflag').val();
        var distcode = $('.districtselectflag').val();
        var circode = $('.circleselectflag').val();
        var mouzacode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getLotNoJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Lot</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].lot_no + "'>" + lot[i].loc_name + "</option>";
                }
                console.log(template);
                $('.lotselectflag').html(template);
            }
        });
    });


    $('.lotselectflag').change(function (e) {
        var subdivcode = $('.subdivselectflag').val();
        var distcode = $('.districtselectflag').val();
        var circode = $('.circleselectflag').val();
        var mouzacode = $('.mouzaselectflag').val();
        var lotcode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getVillageCodeFlaggedJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Village</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].vill_townprt_code + "'>" + lot[i].loc_name+" " +lot[i].villtype +"</option>";
                }
                console.log(template);
                $('.villageselectflagged').html(template);
            }
        });
    });
</script>
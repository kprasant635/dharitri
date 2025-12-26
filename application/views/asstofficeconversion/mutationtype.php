
<div class="row login">

    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px"><?php echo $this->lang->line('petition_form_for_conversion'); ?></h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>

            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Note<span style="color: red">*</span>: Select patta no and patta type for conversion process.</h3>
                </div>
                <div class="panel-body">

                    <form class='form-horizontal unicode' method="post" action="<?php echo base_url() . 'index.php/AsistantMutationPartha/saveConvertionTrnsfrDetails' ?>">
                        <input type="hidden" readonly value="<?php echo $location['dist_code']; ?>" class="form-control districtselect" name="dist_code">
                        <input type="hidden" readonly value="<?php echo $location['subdiv_code']; ?>" class="form-control subdivselect" name="subdiv_code">
                        <input type="hidden" readonly value="<?php echo $location['cir_code']; ?>" class="form-control circleselect" name="cir_code">
                        <input type="hidden" readonly value="<?php echo $location['mouza_pargona_code']; ?>" class="form-control mouzaselect" name="mouza_pargona_code">
                        <input type="hidden" readonly value="<?php echo $location['lot_no']; ?>" class="form-control lotselect" name="lot_no">
                        <input type="hidden" readonly value="<?php echo $location['vill_code']; ?>" class="form-control villageselect" name="vill_townprt_code">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control pattatype_nmae" id="new_patta_type" name="patta_type" required >
                                    <option selected disabled><?php echo $this->lang->line('select_patta_type'); ?></option>
                                    <?php
                                    foreach ($patta_conv_type as $value) {
                                        echo "<option value='$value->type_code'>$value->patta_type</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label required" ><?php echo $this->lang->line('patta_no'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                    <option>Select Patta No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('addressing_officer'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control desig_on_name" id="n" name="add_of_co_code">
                                    <option selected disabled><?php echo $this->lang->line('address_to_the_officer'); ?></option>
                                    <?php foreach ($user as $u): ?>
                                        <option value="<?php echo $u['user_code']; ?>"><?php echo $u['co_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $this->lang->line('designation'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="designation" placeholder="গ্রহনকাৰী বিষয়া" name="add_of_desig" readonly>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-12 alert alert-success" style="margin: 0 auto;float: none;text-align: center">
                                <label class="checkbox-inline bold">
                                    <input type="checkbox" id="inlineCheckbox1" name='availabe_doc' value="y"> <?php echo $this->lang->line('required_doc'); ?>
                                </label>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class="btn btn-success" onclick="return check();"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/Conversion"; ?>" class="btn btn-danger">
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
</script>




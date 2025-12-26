<script>
    $(function () {
        var dagNo = "" +<?php echo $NewDag['dag']; ?>;
        var pattaNo = "" +<?php echo $NewPatta['patta']; ?>;
        /* $("input[name='newDag']").change(function (e) {
            if ($(this).val() < parseInt(dagNo)) {
                $('#btn-hide').hide();
                alert("Your entered Dag cannot be less than suggested by Dharitree");
                $('#msgModal .modal-body p').html("The New Dag You Entered Already Exists in Dhartitree. Consult offline documents");
                $('#msgModal').modal();
            } else {
                $('#btn-hide').show();
            }
        }); */

        // $("input[name='newPatta']").change(function (e) {
            // if ($(this).val() < parseInt(pattaNo)) {
                // $('#btn-hide').hide();
                // alert("Your entered Patta No cannot be less than suggested by Dharitree");
                // $('#msgModal .modal-body p').html("The New Patta You Entered Already Exists in Dhartitree. Consult offline documents");
                // $('#msgModal').modal();
            // } else {
                // $('#btn-hide').show();
            // }
        // });
    })
</script>
<div class="modal fade" id="msgModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#ccc;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">You are in the process of Office Partition</h4>
            </div>
            <hr>
            <div class="modal-body">
                <p class="alert alert-info">You can edit the Suggested Dag No and Patta No in this Page in the Red Colored Boxes.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid form-top login ">
    <div class="row" style="padding: 10px">
        <div class="col-sm-10 col-sm-offset-1 panel-form">
            <?php //echo print_r($land); ?>
            <form class="form-horizontal" id="formOne"  method="POST" action="<?php echo base_url(); ?>index.php/partition/COInFavOfDtls">
                <?php //var_dump($values);?>
                <h2 class="uni_text text-center text-danger"><?php echo $this->lang->line('basic_order_details'); ?></h2>
                <hr>
                <?php
                $arr = sizeof($values);
                if ($arr != 0) {
                    foreach ($values as $v) :
                        $pdar_cron_no = $v->pdar_cron_no;
                        ?>
                        <fieldset>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('serial_number') ?></label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" readonly="" name="pdar_cron_no" value="<?php echo $v->pdar_cron_no ?>" >
                                    <input type="hidden" class="form-control" name="infavourOf" value="<?php echo $v->pdar_id ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('case_no') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="ordNo" value="<?php echo $this->session->userdata('case_no') ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('date') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" readonly="" name="ordDate" value="<?php echo date('d-m-Y', strtotime($pbdata->submission_date)) ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('old_patta_no') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" name="pattaNo" value="<?php echo $v->patta_no; ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-3 control-label uni_text"><?php echo $this->lang->line('patta_type') ?></label>
                                <div class="col-sm-3">
                                  
                                    <input type="text" class="form-control" name="pattaName" readonly="" value="<?php echo $this->utilityclass->getPattaName($v->patta_type_code); ?>" >
                                    <input type="hidden" name="pattaCode" value="<?php echo $v->patta_type_code; ?>" >
                                </div>

                            </div> 
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('applicant_name') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" readonly="" class="form-control" name="inFavourName" value="<?php echo $v->pdar_name; ?>" >
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label uni_text" id='applicant_name_label'><?php echo $this->lang->line('gender') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    $sex = $v->pdar_gender;
                                    if ($sex == 'M') {
                                        $gender = "পুৰুষ";
                                    } else {
                                        $gender = "মহিলা";
                                    }
                                    ?>
                                    <input type="text" readonly="" class="form-control"  value="<?php echo $gender; ?>" >
                                    <input type="hidden" value="<?php echo $v->pdar_gender; ?>" name="inFavourSex">
                                </div>
                            </div> 

                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('guardian_name') ?> </label>
                                <div class="col-sm-3">
                                    <input type="text" readonly="" class="form-control" name="inFavourGurd" value="<?php echo $v->pdar_guardian; ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('relation') ?> </label>
                                <div class="col-sm-3">

                                    <select class="form-control" name="guar_rel">
                                        <option value="<?php echo $v->pdar_rel_guar; ?>"><?php echo $this->utilityclass->get_relation($v->pdar_rel_guar); ?></option>
                                        <?php
                                        foreach ($relation as $r) {
                                            ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as ?></option>
                                        <?php } ?>
                                    </select>

                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('mothers_name') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" readonly="" class="form-control" name="inFavourMother" value="<?php echo $v->pdar_mother; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="infavourAdd1" value="<?php echo $v->pdar_add1 ?>" >
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="infavourAdd2" value="<?php echo $v->pdar_add2 ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('mobile_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pdar_mobile" id="pdar_mobile" readonly="" value="<?php echo $v->pdar_mobile ?>" name="pdar_mobile" placeholder="Mobile Number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('aadhar_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control uni_text pdar_aadhar" id="pdar_aadhar" readonly="" value="<?php echo $v->pdar_aadharno ?>" name="pdar_aadhar" placeholder="Aadhar Number">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text  control-label"><?php echo $this->lang->line('nrc_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pdar_nrc" id="pdar_nrc" readonly="" value="<?php echo $v->pdar_nrcno ?>" name="pdar_nrc" placeholder="NRC Number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('pan_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pdar_pan" id="pdar_pan" readonly="" value="<?php echo $v->pdar_pan_no ?>" name="pdar_pan" placeholder="PAN Number">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('voter_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pdar_voterID" readonly="" id="pdar_voterID" value="<?php echo $v->pdar_citizen_no ?>" name="pdar_voterID" placeholder="Voter ID">
                                </div>
                            </div>

                            <hr>
                            <h2 class="uni_text text-center text-danger"><?php echo $this->lang->line('dag_area'); ?> </h2>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('bigha') ?></label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="LandB" readonly value="<?php echo $land->m_dag_area_b ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"> <?php echo $this->lang->line('katha') ?></label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="LandK" readonly value="<?php echo $land->m_dag_area_k ?>" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('lesa') ?></label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="LandL" readonly value="<?php echo $land->m_dag_area_lc ?>" >
                                </div>
                            </div>
                            <hr>
                            <p class="green"> Note : New Dag / Patta Number will be wrongly generate if there exist junk dag/patta in the village. So, please check and edit it,if needed.</p>
                            <span class='red uni_text'>Auto Generated Dag Number and Patta Number Should be Verified with the Existing Old Dag and Office Hard Copy Chitha </span>
                            <p class='hide'>An Important Note: <?php //echo $msg[0].$msg[1];   ?></p>
                            <hr>
                            <?php
                            //var_dump($exists_dag_patta);
                            ?>

                            <div class="form-group">
                                <?php
                               // print_r($PattadarCount);
                               $complete = strtolower($pbdata->complete_partition_yn);
                               $pdar_strike=0;
                                if (($complete == 'y')) {
                                    //print_r($oldDag)
                                    ?>
                                    <label for="inputEmail" class="col-sm-2 control-label">Old / Merge Dag No</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="newDag" readonly="" value="<?php echo $v->dag_no; ?>" >
                                        <input type="hidden" value="<?php echo $v->dag_no ?>" name="oldDag">
                                    </div>
                                    <?php
                                } elseif ($complete == 'n') {
                                    $pdar_strike='Y';
                                    ?>
                                    <label for="inputEmail" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('dag_no') ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="newDag" value="<?php echo $NewDag['dag']; ?>" >
                                        <input type="hidden" value="<?php echo $v->dag_no ?>" name="oldDag">
                                    </div>
                                    <?php
                                } elseif (($complete == 'y')  and ($pdar_cron_no == '1')) {
                                    ?>
                                    <label for="inputEmail" class="col-sm-2 control-label uni_text text-danger"><?php echo $this->lang->line('new_dag_no') ?> </label>
                                    <div class="col-sm-2">
                                        <input type="text" style="box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);" class="form-control"  name="newDag" value="<?php echo $NewDag['dag']; ?>" >
                                        <input type="hidden" value="<?php echo $v->dag_no ?>" name="oldDag">
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <label for="inputEmail" class="col-sm-2 control-label uni_text text-danger"><?php echo $this->lang->line('new_dag_no') ?> </label>
                                    <div class="col-sm-2">
                                        <input type="text" style="box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);" class="form-control" readonly=""   name="newDag" value="<?php echo $this->session->userdata('postDagNo'); ?>" >
                                        <input type="hidden" value="<?php echo $v->dag_no ?>" name="oldDag">
                                    </div>
                                    <?php
                                }
                                ?>
                                <label for="inputEmail" class="col-sm-3 control-label uni_text">Check The Existing Dags</label>
                                <div class="col-sm-2">
                                    <select class="form-control"  >
                                        <?php foreach ($oldDag as $odag) { ?>
                                            <option> <?php echo $odag->dag_no ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label uni_text text-danger"><?php echo $this->lang->line('new_patta_no') ?></label>
                                <?php if ($plmnote->sugg_pno != null or $plmnote->sugg_pno != '') { ?>
                                    <div class="col-sm-3">
                                        <input  type="text" readonly="" class="form-control" name="newPatta" value="<?php echo $plmnote->sugg_pno ?>" >
                                    </div>
                                    <?php
                                } elseif ($pdar_cron_no == '1') {
                                    ?>
                                    <div class="col-sm-2">
                                        <input type="text" style="box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);"  class="form-control" name="newPatta" value="<?php echo $NewPatta['patta']; ?>" >
                                    </div>
                                <?php } else {
                                    ?>
                                    <div class="col-sm-2">
                                        <input type="text" style="box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);"  class="form-control" readonly name="newPatta" value="<?php echo $this->session->userdata('postPattaNo'); ?>" >
                                    </div>
                                    <?php
                                }
                                ?>
                                <label for="inputEmail" class="col-sm-3 control-label uni_text">Check The Existing Pattas</label>
                                <div class="col-sm-2">
                                    <select class="form-control"  >
                                        <?php foreach ($oldPatta as $odag) { ?>
                                            <option> <?php echo $odag->patta_no ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class='form-group'>
                                <label for="inputEmail" class="col-sm-2 control-label uni_text"><?php echo $this->lang->line('revenue') ?> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control"  required="" value="<?php echo number_format($revenue, 2); ?>" ><span class='red'>(Per Bigha)</span>
                                    <input type="hidden" class="form-control" readonly="" required="" value="<?php echo $revenue; ?>" name="revenue" >
                                </div>
                            </div>
                           
                            <div class="col-lg-12 center-block"><div><hr style="border-color:#000000"></div>
                                <div class="checkbox  ">
                                    <label><input class="squaredTwo" name="deed_y_n" type="checkbox" value="Yes"> </label>
                                    <span class="text-danger uni_text" style="margin-left: 10px">  Check this box if Deed Data Exists  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('deed_no') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" id="deed_no" class="form-control" name="RegDeedNo" >
                                </div>
                                <label for="inputEmail" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('deed_value') ?> (Rs.)</label>
                                <div class="col-sm-3">
                                    <input type="text" id="deed_value"  class="form-control" name='RegDeedValue' >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('registration_date'); ?> (dd/mm/yyyy)</label>
                                <div class="col-sm-3">
                                    <input type="text"  class="reg_date  form-control"   name='reg_date'  placeholder="dd/mm/yyyy"
                                           onkeyup="
                                                                               var v = this.value;
                                                                               if (v.match(/^\d{2}$/) !== null) {
                                                                                   this.value = v + '/';
                                                                               } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
                                                                                   this.value = v + '/';
                                                                               }"
                                           maxlength="10">
                                </div>
                                <label for="inputEmail" class="col-sm-2 uni_text control-label"><?php echo $this->lang->line('sub_registration_office'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" id="sub_regOffice" class="form-control" name='sub_regOffice' >
                                    <input type="hidden" name="pdar_strike" value="<?php echo $pdar_strike; ?>">
                                </div>
                            </div>
                            <hr> 
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-4">
                                    <button id='btn-hide' type="submit" name="formsubmit" class="btn btn-primary uni_text"><?php echo $this->lang->line('submit_button'); ?><i class="fa fa-arrow-circle-o-right"></i></button>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        <?php
                    endforeach;
                } else {
                    redirect(base_url() . "index.php/partition/UpdateData");
                }
                ?>
            </form>
        </div>
    </div>
</div>
<script>
    $('#formOne input[name=deed_y_n]').change(function (e) {
        var status = $('#formOne input[name=deed_y_n]').is(':checked');
        if (status) {
            $('#deed_no').prop("disabled", false);
            $('#deed_value').prop("disabled", false);
            $('.reg_date').prop("disabled", false);
            $('#sub_regOffice').prop("disabled", false);

        } else {
            $('#deed_no').prop("disabled", true);
            $('#deed_value').prop("disabled", true);
            $('.reg_date').prop("disabled", true);
            $('#sub_regOffice').prop("disabled", true);

        }
    });
    $('#formOne input[name=deed_y_n]').trigger('change');
    $("#dmy").inputmask("d/m/y", {"placeholder": "dd/mm/yyyy"});

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
</script>

